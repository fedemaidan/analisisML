<?php

namespace AppBundle\Service;

use AppBundle\Entity\PublicacionML;
use AppBundle\Entity\PublicacionPropia;
use AppBundle\Entity\AtributoML;
use AppBundle\Entity\Producto;
use AppBundle\Entity\CategoriaML;
use AppBundle\Entity\BusquedaML;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Utils\Meli\Meli;
use GuzzleHttp\Client;

/**
 * Include the SDK by using the autoloader from Composer.
 */



class MeliService
{
    const DOLAR = 43;
    const MATCH_ARRAY = [
                            "titulo"        => "title",
                            "categoriaML"   => "category_id",
                            "precioCompra"  => "price",
                            "estado"        => "status",
                            "descripcion"   => "description"
                        ];

	private $container;
    
    /**
    *
    * @var EntityManager
    */
    private $em;

    public function __construct( Container $container, EntityManager $entityManager )
    {
        $this->container = $container;
        $this->em = $entityManager;
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
    }

    public function buscarCategoriasHijas($categoriaML) {
        $meli = new Meli("","");

        $this->imprimo("Comienza categrias hijo de .. ".$categoriaML->getNombre());
        
        $datos = $meli->get("categories/".$categoriaML->getIdMl());
        
        $results = $datos["body"]->children_categories;
        
        foreach ($results as $key => $categoriaDatos) {
            
            $categoria = $this->addCategoria($categoriaDatos);
            $categoria->setCategoriaPadre($categoriaML);
            $this->em->persist($categoria);
            $this->buscarCategoriasHijas($categoria);
        }

        $this->em->flush();
    }

    public function cargoCategoriasPadres($recursividad = true) {
        $meli = new Meli("","");

        $this->imprimo("Comienza .. ");
        
        $datos = $meli->get("sites/MLA/categories");
        
        $results = $datos["body"];
        
        foreach ($results as $key => $categoriaDatos) {
            $categoria = $this->addCategoria($categoriaDatos);
            $this->em->persist($categoria);
            if ($recursividad) $this->buscarCategoriasHijas($categoria);
        }

        $this->em->flush();
        
    }

    public function addCategoria($categoriaDatos) {
        $categoria = $this->em->getRepository(CategoriaML::class)->findOneByIdMl($categoriaDatos->id);

        if (!$categoria) {
            $categoria = new CategoriaML();
            $categoria->setIdMl($categoriaDatos->id);
        }
        
        $categoria->setNombre($categoriaDatos->name);
        
        return $categoria;
    }


    public function cargarPublicacion($publicacionDatos, $clase) {
            $meli = new Meli("","");
    		$publicacion = $this->em->getRepository("AppBundle:".$clase)->findOneByIdMl($publicacionDatos->id);

            if (!$publicacion) {
                $initClase = "AppBundle\Entity\\".$clase;
                $publicacion = new $initClase;
                $datosItem = $meli->get("items/".$publicacionDatos->id);
                $datosItem = $datosItem["body"];

                if (isset($datosItem->pictures)) {
                    
                    $pictures = "";
                    foreach ($datosItem->pictures as $key => $value) {
                        $pictures .= $value->url.",";
                    }

                    $publicacion->setImagenes($pictures);
                }
                
                    
                    if (isset($datosItem->attributes)) {
                        foreach ($datosItem->attributes as $key => $attr) {
                            
                            $atributo = $this->em->getRepository(AtributoML::class)
                                ->findOneBy(["idMl" => $attr->id, "valueName" => $attr->value_name]);

                            if (!$atributo) {
                                $atributo = new AtributoML();
                                $atributo->setIdMl($attr->id);
                                $atributo->setName($attr->name);
                                $atributo->setValueId($attr->value_id);
                                $atributo->setValueName($attr->value_name);
                                $atributo->setAttributeGroupId($attr->attribute_group_id);
                                $atributo->setAttributeGroupName($attr->attribute_group_name);
                                $this->em->persist($atributo);
                                $this->em->flush();
                            }

                            if ($clase != "PublicacionPropia") {
                                if ($atributo->getIdMl() == 'UPC') {
                                    
                                        $publicacion->setUpc((int)$atributo->getValueName());
                                }

                                if ($atributo->getIdMl() == 'BRAND') {
                                    $publicacion->setBrand($atributo->getValueName());
                                }

                                if ($atributo->getIdMl() == 'MODEL') {
                                    $publicacion->setModel($atributo->getValueName());
                                }

                                if ($atributo->getIdMl() == 'MPN') {
                                    $publicacion->setMpn($atributo->getValueName());
                                }

                                if ($atributo->getIdMl() == 'EAN') {
                                    $publicacion->setEan((int)$atributo->getValueName());
                                }
                            }
                            
                            $publicacion->addAtributo($atributo);
                        }
                    } 
                if ($clase == "PublicacionPropia") { 
                    $desc = $meli->get("items/".$publicacionDatos->id."/description");
                    $publicacion->setDescripcion($desc["body"]->plain_text);
                }
                
            }
            
            $idPubli = $publicacionDatos->id;
            $visits = $meli->get("visits/items?ids=".$publicacionDatos->id);
            $publicacion->setCantidadVistas($visits["body"]->$idPubli);
            $publicacion->setIdMl($publicacionDatos->id);
            $publicacion->setTitulo($publicacionDatos->title);
            $publicacion->setPrecioCompra($publicacionDatos->price);
            $publicacion->setLink($publicacionDatos->permalink);
            $publicacion->setVendedor($publicacionDatos->seller->id);
            $publicacion->setCantidadVendidos($publicacionDatos->sold_quantity);
            $publicacion->setCategoriaML($publicacionDatos->category_id);

            $publicacion->cancelSinc();
            
            /* Cargar datos */
            $this->em->persist($publicacion);	

            return $publicacion;
    }

    public function buscarPublicacionesPorCategoria($busquedaId) {
        $busqueda = $this->em->getRepository(BusquedaML::class)->findOneById($busquedaId);;

        $mayorA = '*';
        $menorA = '*';
        $categoria = $busqueda->getCategoriaML()->getIdMl();
    	

        if ($busqueda->getPrecioMaximo())
            $menorA = $busqueda->getPrecioMaximo();
        if ($busqueda->getPrecioMinimo())
            $mayorA = $busqueda->getPrecioMinimo();
        
        $condicionML = "category=".$categoria."&condition=new&price=".$mayorA."-".$menorA;
        $clase = "PublicacionML";

        $this->cargarPublicacionesPorCondicion($condicionML, $clase, $busqueda);
    }

    public function cargarPublicacionesPorCondicion($condicionML, $clase, $busqueda) {

    	$meli = new Meli("","");
    	$limit = 50;
    	$offset = 0;
    	$total = 2;
    	$publicacionesNuevas = 0;
    	$this->imprimo("Comienza .. ");
        $this->cambiarEstadoBusqueda($busqueda, "Comenzando .. ");
        
    	while ($total > $offset) {
            //igual con otra condicion

    		$datos = $meli->get("sites/MLA/search/?".$condicionML."&limit=".$limit."&offset=".$offset);

    		$paging = $datos["body"]->paging;
    		$results = $datos["body"]->results;
            

            if ($paging->total >  1000)
            {
                //igual cambiando estado cuenta
                $this->cambiarEstadoBusqueda($busqueda, "La búsqueda es demasiado grande. El máximo de publicaciones es 1000 y la búsqueda tiene ".$paging->total." publicaciones");
            }
                
    		$this->imprimo("Offset: ".$offset);

    		foreach ($results as $key => $publicacionDatos) {
                //igual cargando otra clase
                $publicacion = $this->cargarPublicacion($publicacionDatos, $clase);
                
                if ($publicacion->getId() == null) {
                    $publicacionesNuevas++;
                }
    		}

    		$this->em->flush();

    		$total = $paging->total;
    		$offset = $paging->offset + $limit;
            $porcentajeProcesado = round(($offset / $total) * 100) ;

            $this->imprimo("Publicaciones cargadas -> ".$publicacionesNuevas);
            $this->cambiarEstadoBusqueda($busqueda, $porcentajeProcesado."% procesado. Publicaciones cargadas: ".$publicacionesNuevas);
    	}

        $this->imprimo("Proceso terminado ");
        $this->cambiarEstadoBusqueda($busqueda, "Finalizado");
    }

    public function replicarPublicacionEbayEnMl($ebay, $cuentaML) {

        $publicacionExistente = $this->em->getRepository(PublicacionPropia::class)->findOneBy([ "publicacion_ebay" => $ebay]);

        if ($publicacionExistente != null) {
            var_dump("Ya esta cargada ".$ebay->getId());
            return;
        }

        $publicacion = $this->ebayToMlObj($ebay, $cuentaML);
        $datos = $this->publicar($publicacion);
        if (isset($datos["body"]->id)) {
            $publicacion->setIdMl($datos["body"]->id);
            $publicacion->setLink($datos["body"]->permalink);
            $publicacion->setVendedor($datos["body"]->seller_id);
            $this->em->persist($publicacion);
            $this->em->flush();
        }
        else {
            var_dump("Error cargando publicacion ".$ebay->getId());
            var_dump($datos);
        }
    }

    public function publicar($publicacion) {
        $token = $this->dameToken($publicacion->getCuenta());

        $arrayimagenes = explode(',', $publicacion->getImagenes());
        $imagenes = [];
        foreach ($arrayimagenes as $key => $img) {
            $imagenes[] = ["source" => $img];
        }

        $body = [
                "title" =>$publicacion->getTitulo(),
                "category_id"=>$publicacion->getCategoriaML(),
                "price"=>$publicacion->getPrecioCompra(),
                "currency_id"=>"ARS",
                "available_quantity"=>99,
                "buying_mode"=>"buy_it_now",
                "condition" => "new",
                "listing_type_id"=>"gold_special",
                "description"=> [ "plain_text" => $publicacion->getDescripcion()],
                "sale_terms"=>[
                        ["id"=> "WARRANTY_TIME", "value_name"=> "180 dias"]
                ],
                "pictures"=> $imagenes
            ];
            
        $meli = new Meli("","");
        $datos = $meli->post("items", $body, [ "access_token" => $token ]);
        
        return $datos;
    }

    public function actualizarPublicacion($publicacionPropia) {
        $ebay = $publicacionPropia->getPublicacionEbay();
        $precio = $this->calcularPrecio($ebay->getCategoriaEbay(), $ebay->getPrecioCompra());
        
        $publicacionPropia->setTitulo($this->armarTitulo($ebay->getTitulo()));
        $publicacionPropia->setDescripcion($this->generarDescripcion($ebay));
        $publicacionPropia->setPrecioCompra($precio);


        foreach ($ebay->getEspecificaciones() as $key => $especificacion) {
            /** Buscamos un attributo con nombre y valor igual al de la especificacion */
            $nombreEspecificacion = $especificacion->getName();
            $atributo = $this->em->getRepository(AtributoML::class)
            ->findOneBy(["ebayName" => $nombreEspecificacion, "valueName" => $especificacion->getValue()]);


            if (!$atributo && ($nombreEspecificacion == "MPN" || $nombreEspecificacion == "UPC" || $nombreEspecificacion == "EAN")) {
                $atributo = new AtributoML();
                $atributo->setIdMl($nombreEspecificacion);
                $atributo->setName($nombreEspecificacion);
                $atributo->setValueName($especificacion->getValue());
                $atributo->setAttributeGroupId("OTHERS");
                $atributo->setAttributeGroupName("Otros");
                $atributo->setEbayName($nombreEspecificacion);
                $this->em->persist($atributo);
                $publicacionPropia->addAtributo($atributo);
            }
            
            if (!$atributo && ($nombreEspecificacion == "Compatible Operating System" || $nombreEspecificacion == "Compatibility")) {
                if ($especificacion->getValue() == "ios") {
                    $atributo = $this->em->getRepository(AtributoML::class)->findOneBy(["ebayName" => $nombreEspecificacion, "valueName" => "iOS"]);
                }
                if ($especificacion->getValue() == "Android" || strpos($ebay->getTitulo(), 'pple') === false) {
                    $atributo = $this->em->getRepository(AtributoML::class)->findOneBy(["ebayName" => $nombreEspecificacion, "valueName" => "Android"]);
                }

                $publicacionPropia->addAtributo($atributo);
            }


            if (!$atributo && ($nombreEspecificacion == "Waterproof")) {

                $atributo1 = $this->em->getRepository(AtributoML::class)->findOneBy([ "idMl" =>  "IS_WATER_RESISTANT", "valueName" => "Sí"]);
                $atributo2 = $this->em->getRepository(AtributoML::class)->findOneBy([ "idMl" =>  "IS_WATERPROOF", "valueName" => "Sí"]);
                $publicacionPropia->addAtributo($atributo1);
                $publicacionPropia->addAtributo($atributo2);
            }


        }

        $this->em->persist($publicacionPropia);
        $this->em->flush();
    }

    public function editarCamposPublicacionMercadolibre($publicacionPropia, $campos = [] ) {
        
        $token = $this->dameToken($publicacionPropia->getCuenta());
        $meli = new Meli("","");
        $body = [ ];
        $desc = [ ];

        foreach ($campos as $key => $campo) {
            if (array_key_exists($key ,self::MATCH_ARRAY)){
                if ($key != "descripcion")
                    $body[self::MATCH_ARRAY[$key]] = $campo[1];
                else {
                    $desc["plain_text"] = $campo[1];
                    $desc["text_plain"] = $campo[1];
                    $desc["text"] = $campo[1];
                    $datos = $meli->put("items/".$publicacionPropia->getIdMl()."/description", $desc, [ "access_token" => $token ]);
            
                    if ($datos["httpCode"] != 200 ) {
                        throw new \Exception($datos["body"]->message, 1);
                    }
            
                }
            }
        }
/*
        $atributos = [];
        foreach ($publicacionPropia->getAtributos() as $key => $attr) {
            $atributos[] = ["id" => $attr->getIdMl(), "value_name" => $attr->getValueName() ];
            var_dump(["id" => $attr->getIdMl(), "value_name" => $attr->getValueName() ]);
        }

        if (count($atributos) > 0)
            $body["attributes"] = $atributos;
        if (count($body) > 0) {
            $datos = $meli->put("items/".$publicacionPropia->getIdMl(), $body, [ "access_token" => $token ]);
        
            if ($datos["httpCode"] != 200 ) {
                throw new \Exception($datos["body"]->message, 1);
            }

            return $datos;
        }
*/        

    }

    

    public function sincronizarPublicacionesPropiasConMercadoLibre($cuenta) {
        
        $condicionML = "seller_id=".$cuenta->getIdMl();
        $clase = "PublicacionPropia";

        $this->cargarPublicacionesPorCondicion($condicionML, $clase, $cuenta);
    }
    
    public function ebayToMlObj($ebay, $cuentaML) {
        
        $publicacion = new PublicacionPropia();
        $publicacion->setPublicacionEbay($ebay);
        $precio = $this->calcularPrecio($ebay->getCategoriaEbay(), $ebay->getPrecioCompra());
        $publicacion->setTitulo($this->armarTitulo($ebay->getTitulo()));
        $publicacion->setDescripcion($this->generarDescripcion($ebay));
        $publicacion->setPrecioCompra($precio);
        $publicacion->setCuenta($cuentaML);
        $imagenes = $ebay->getImagenes();
        $imagnesArray = explode(",", $imagenes);
        
        if (count($imagnesArray) > 12) {
            $imagnesArray2 = [];
            foreach ($imagnesArray as $key => $value) {
                if ($key == 12) continue;
                $imagnesArray2[] = $value;
            }

            $imagenes = implode(',', $imagnesArray2);
        }

        $publicacion->setImagenes($imagenes);
        $publicacion->setCategoriaML($this->predecirCategoria($publicacion));
        
        foreach ($ebay->getEspecificaciones() as $key => $especificacion) {
            /** Buscamos un attributo con nombre y valor igual al de la especificacion */
            $nombreEspecificacion = $especificacion->getName();
            $atributo = $this->em->getRepository(AtributoML::class)
            ->findOneBy(["ebayName" => $nombreEspecificacion, "valueName" => $especificacion->getValue()]);

            if ($atributo) {
                $publicacion->addAtributo($atributo);
            }

        }

        return $publicacion;
    }

    private function armarTitulo($texto) {
        $sufijo = "**CONSULTAR STOCK";
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        
        return $texto.$sufijo;
    }

    private function predecirCategoria($publicacion) {
        return "MLA399230";
        $meli = new Meli("","");
        $titulo = str_replace("&", " ", $publicacion->getTitulo());
        $titulo = str_replace("\"", " ", $titulo);
        
        $url = "sites/MLA/category_predictor/predict?title=".$titulo."&seller_id=".$publicacion->getCuenta()->getIdMl()."&price=".$publicacion->getPrecioCompra();
        $url = str_replace(" ", "%", $url);

        $datos = $meli->get($url);
        if ( property_exists($datos["body"], "id") ) {
            return $datos["body"]->id;
        } else {
            return null;
        }
        
        
    }

    private function generarDescripcion($ebay) {

        $descripcion =  "----- YOUTEC ----- CONSULTAR STOCK ------- PRODUCTOS ORIGINALES IMPORTADOS

            En YouTec nosotros estamos convencidos de que la tecnología para la salud debe estar al alcance de todos.

            Una vez ofertado el producto nos comunicamos contigo y te damos un número de reserva para que puedas consultar por el estado de tu pedido en todo momento.
            Tendrás asignado un vendedor para comunicarte con el directamente. Sin intermediarios.

            Luego de esperar entre 2 y 4 semanas estará llegando el producto a tu casa. 

            Se puede pagar al contado o con una seña y completar el pago una vez recibido el producto.
            
            PRODUCTO: ".$ebay->getTitulo();

            
            $descripcion .= "
            
            ESPECIFICACIONES DEL PRODUCTO
            
            ";

            foreach ($ebay->getEspecificaciones() as $espe) {
                $descripcion .= $espe->getName().": ".$espe->getValue()."
                ";
            }

            $descripcion .= "También podes consultar por otros productos que no encuentres dentro de MercadoLibre.
            
            Podes retirar tu producto cerca de la estación de Flores. También hacemos envíos a todo el país.

            Consulta por ofertas especiales. Si lo encontrás a menor precio, comunicate con nosotros que mejoramos nuestra oferta.";    

            return $descripcion;
    }

    private function calcularPrecio($categoria, $precioCompra) {
        /*
        $precioCompra = $precioCompra * 21;
        return $precioCompra * $rentabilidad;
        
        $porcentajeImpuestoPorCategoria = 20;
        $impuesto = $precioCompra * ($porcentajeImpuestoPorCategoria / 100);
        $costoEnvio = 100;
        $comisionML = $precioCompra * 0.12;

        $precio = ($precioCompra + $impuesto + $costoEnvio + $comisionML) * ($rentabilidad + 1);
        */

        $ratio = $categoria->getRatio();
        $shipping = $categoria->getShipping();
        $precio = (($precioCompra * $ratio) + $shipping) * self::DOLAR;
        
        return intdiv($precio, 100) * 100 - 1;
    }

    private function imprimo($texto) {
		echo "\n".date("Y-m-d H:i:s"). " ****** ".$texto;
    }

    public function dameToken($cuenta) {
        $client = new Client();
        $id = $cuenta->getId();
        $id = 30;
        $res = $client->request('GET', 'https://multiml.xyz/token?cuenta_id='.$id);
        

        $dato = json_decode($res->getBody()->getContents());
        
        return $dato->token;
        
    }

    private function cambiarEstadoBusqueda($busqueda, $texto) {
        $busqueda->setEstadoActual(date('Y-m-d H:i:s')." - ".$texto);
        $this->em->persist($busqueda);
        $this->em->flush();
    }
}