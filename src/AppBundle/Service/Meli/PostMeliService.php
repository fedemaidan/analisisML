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


class PostMeliService
{
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
    }    

}