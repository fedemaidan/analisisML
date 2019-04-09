<?php

namespace AppBundle\Service\Meli;

use AppBundle\Entity\PublicacionML;
use AppBundle\Entity\PublicacionPropia;
use AppBundle\Entity\AtributoML;
use AppBundle\Entity\Producto;
use AppBundle\Entity\CategoriaML;
use AppBundle\Entity\BusquedaML;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Utils\Publicador\PublicadorStock;

use GuzzleHttp\Client;
use AppBundle\Service\MeliService;


class PostMeliService extends MeliService {
    const DOLAR = 45;
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

    public function replicarProductoEnMl($producto, $tipoVenta, $comoYouTec, $cuentaML) {

        if ($tipoVenta == PublicadorStock::TIPO_DE_VENTA){
            $publicador = new PublicadorStock( $comoYouTec, $producto);
            $publicacion = $publicador->crearPublicacion();
        }
        
        $publicacion->setCuenta($cuentaML);
        var_dump("expression2");
        $this->publicar($publicacion);
       var_dump("expression");
        return $publicacion;
    }

    public function replicarPublicacionEbayEnMl($ebay, $cuentaML) {

        if (strpos($ebay->getTitulo(), 'Garmin') !== false && strpos($ebay->getCategoriaEbay()->getName(), 'Watch') !== false) {
            return;
        }

        $publicacion = $this->ebayToMlObj($ebay, $cuentaML);
        $datos = $this->publicar($publicacion);
    }


    public function actualizarPublicacion($publicacionPropia) {
        $ebay = $publicacionPropia->getPublicacionEbay();
        $publicacionPropia->armarTitulo();
        $publicacionPropia->armarDescripcion();
        $publicacionPropia->cargarPrecio();
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

        $atributos = [];
        foreach ($publicacionPropia->getAtributos() as $key => $attr) {
            $atributos[] = ["id" => $attr->getIdMl(), "value_name" => $attr->getValueName() ];
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
    }    


    private function publicar($publicacion) {
        $token = $this->dameToken($publicacion->getCuenta());
        var_dump($token);
        $arrayimagenes = explode(',', $publicacion->getImagenes());
        $imagenes = [];
        foreach ($arrayimagenes as $key => $img) {
            $imagenes[] = ["source" => $img];
        }

        $atributos = [];
    
        foreach ($publicacion->getAtributos() as $key => $attr) {
            $atributos[] = ["id" => $attr->getIdMl(), "value_name" => $attr->getValueName() ];
        }

        $body = [
                "title" =>$publicacion->getTitulo(),
                "category_id"=>$publicacion->getCategoriaML(),
                "price"=>$publicacion->getPrecioCompra(),
                "currency_id"=>"ARS",
                "available_quantity"=>99,
                "buying_mode"=>"buy_it_now",
                "attributes"=>$atributos,
                "condition" => "new",
                "video" => $publicacion->getVideo(),
                "listing_type_id"=>"gold_special",
                "description"=> [ "plain_text" => $publicacion->getDescripcion()],
                "sale_terms"=>[
                        ["id"=> "WARRANTY_TIME", "value_name"=> "180 dias"]
                ],
                "pictures"=> $imagenes
            ];

        $meli = new Meli("","");
      
        $datos = $meli->post("items", $body, [ "access_token" => $token ]);

         if (isset($datos["body"]->id)) {
            $publicacion->setIdMl($datos["body"]->id);
            $publicacion->setLink($datos["body"]->permalink);
            $publicacion->setVendedor($datos["body"]->seller_id);
            $this->em->persist($publicacion);
            $this->em->flush();
        }
        else {
            var_dump("Error cargando publicacion ");
            var_dump($body);
            var_dump($datos);
        }
        
        return $datos;
    }

     private function ebayToMlObj($ebay, $cuentaML) {
        
        $publicacion = new PublicacionPropia();
        $publicacion->setPublicacionEbay($ebay);
        $publicacion->armarTitulo();
        $publicacion->armarDescripcion();
        $publicacion->cargarPrecio();
        
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
            // Buscamos un attributo con nombre y valor igual al de la especificacion 
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

        return $publicacion;
    }


    public function dameToken($cuenta) {
        $client = new Client();
        $id = $cuenta->getId();
        $res = $client->request('GET', 'https://notiml.com/token?cuenta_id='.$id);
        $dato = json_decode($res->getBody()->getContents());       
        return $dato->token;
    }


}