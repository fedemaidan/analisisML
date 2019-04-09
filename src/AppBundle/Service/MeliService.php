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


   /* public function cargarPublicacion($publicacionDatos, $clase) {
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
                            else {
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
            
            //Cargar datos 
            $this->em->persist($publicacion);	

            return $publicacion;
    }*/

    
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

    public function sincronizarPublicacionesPropiasConMercadoLibre($cuenta) {
        
        $condicionML = "seller_id=".$cuenta->getIdMl();
        $clase = "PublicacionPropia";

        $this->cargarPublicacionesPorCondicion($condicionML, $clase, $cuenta);
    }

    
    private function imprimo($texto) {
		echo "\n".date("Y-m-d H:i:s"). " ****** ".$texto;
    }

    private function cambiarEstadoBusqueda($busqueda, $texto) {
        $busqueda->setEstadoActual(date('Y-m-d H:i:s')." - ".$texto);
        $this->em->persist($busqueda);
        $this->em->flush();
    }
}