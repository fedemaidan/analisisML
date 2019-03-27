<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\PublicacionML;
use AppBundle\Entity\PublicacionPropia;
use AppBundle\Entity\PublicacionEbay;
use AppBundle\Entity\Producto;

class ProductosService
{

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

    /* Por cada publicación de ML busco producto en YouTec*/
            /* Si existe, cargo datos faltantes */
            /* Si no existe, cargo el producto */
            /* Relaciono producto con la publicación ML */


    public function cargaProductosDesdeMLGeneral($clase) {
        //$publicacionesML = $this->em->getRepository(PublicacionML::class)->damePublicacionesProducto(null);
        $quedanPublisSinProducto = true;
        while ($quedanPublisSinProducto) {
            $publicacionesML = $this->em->getRepository($clase)->damePublicacionesProducto(null);
            
            $count = 0;

            foreach ($publicacionesML as $key => $publiML) {
                $producto = $this->dameProducto($publiML);
                $publiML->setProducto($producto);
                $this->em->flush(); 
            }

            if (count($publicacionesML) == 0) {
                $quedanPublisSinProducto = false;
            }

            $this->imprimo("Se actualizaron ".count($publicacionesML)." publicaciones");
        }
    }

    public function cargaProductosDesdeMLPropio() {
        $publicaciones = $this->em->getRepository(PublicacionPropia::class)->findAll();
        foreach ($publicaciones as $publi) {
            foreach($publi->getAtributos() as $attr) {
                if ($attr->getIdMl() == 'BRAND')
                    $publi->setBrand($attr->getValueName());
                if ($attr->getIdMl() == 'MODEL')
                    $publi->setModel($attr->getValueName());
            }
        }
        
        $this->em->flush();
        
        $this->cargaProductosDesdeMLGeneral(PublicacionPropia::class);
    }
    
    public function cargaProductosDesdeML() {
        $this->cargaProductosDesdeMLGeneral(PublicacionML::class);
    }

    public function cargaProductosDesdeEbay() {
        
        $publicacionesEbay = $this->em->getRepository(PublicacionEbay::class)->findByProducto(null);
        
        foreach ($publicacionesEbay as $publi) {

            /* Revisar si existe el producto */
            $upc = $publi->getUpc();
            $mpn = $publi->getMpn();
            $ean = $publi->getEan();

            $brand = $this->comprimirTexto($publi->getBrand());
            $model = $this->comprimirTexto($publi->getModel());
            
            $productos = $this->em->getRepository(Producto::class)->dameProductos(null, null, $upc, $mpn, $ean);

            /* Comparo productos */
            if (count($productos) == 0) {    
                $producto = new Producto();
                $producto->setNombre('CARGAR NOMBRE');
                $producto->setCantidad(0);
                $producto->setUpc($upc);
                $producto->setMpn($mpn);
                $producto->setEan($ean);
                $producto->setMarca($brand);
                $producto->setModelo($model);
                $publi->setProducto($producto);
                
                $this->em->persist($producto);
            } else if (count($productos) == 1) {
                $producto = $productos[0];
                if ($producto->getUpc() == null)
                    $producto->setUpc($upc);
                if ($producto->getMpn() == null)
                    $producto->setMpn($mpn);
                if ($producto->getEan() == null)
                    $producto->setEan($ean);
                if ($producto->getMarca() == null)
                    $producto->setMarca($brand);
                if ($producto->getModelo() == null)
                    $producto->setModelo($model);
                
                $publi->setProducto($producto);

                $this->em->persist($producto);   
            }
            else {
                try {
                    $producto = $this->fusionarProductos($productos);
                    $publi->setProducto($producto);
                } catch(\Exception $e) {
                    foreach ($productos as $prod) {
                        var_dump($prod->getId()." Producto duplicado");
                    }
                    $producto = $productos[0];
                }                    
            }

            $this->em->flush(); 
        }
    }

    private function dameProducto($publiML) {

        $upc = $publiML->getUpc();
        $mpn = $publiML->getMpn();
        $brand = $this->comprimirTexto($publiML->getBrand());
        $model = $this->comprimirTexto($publiML->getModel());
        $ean = $publiML->getEan();
                                                                            
        $productos = $this->em->getRepository(Producto::class)->dameProductos($brand, $model, $upc, $mpn, $ean);
        //$productos = $this->em->getRepository(Producto::class)->dameProductos($brand, $model, null,null, null);
        // $productos = $this->em->getRepository(Producto::class)->findBy(['marca' => $brand,
        //                                                                 'modelo' => $model]);

        /* Comparo productos */
        if (count($productos) == 0) {
            $this->imprimo("Producto nuevo: ".$brand."_".$model);
            $producto = new Producto();
            $producto->setNombre($brand." ".$model);
            $producto->setCantidad(0);
            $producto->setUpc($upc);
            $producto->setMpn($mpn);
            $producto->setEan($ean);
            $producto->setMarca($brand);
            $producto->setModelo($model);
            $imagenes = $ebay->getImagenes();
            $publicacion->setImagenes($imagenes);
        

            $this->em->persist($producto);
        }
        else if (count($productos) == 1) {
            $producto = $productos[0];
            if ($producto->getUpc() == null)
                $producto->setUpc($upc);
            if ($producto->getMpn() == null)
                $producto->setMpn($mpn);
            if ($producto->getEan() == null)
                $producto->setEan($ean);
            if ($producto->getMarca() == null)
                $producto->setMarca($brand);
            if ($producto->getModelo() == null)
                $producto->setModelo($model);

            $imagenes = $ebay->getImagenes();
            var_dump($imagenes);
            $publicacion->setImagenes($imagenes);

            $this->em->persist($producto);   
        }
        else {
            try {
                $producto = $this->fusionarProductos($productos);
            } catch(\Exception $e) {
                foreach ($productos as $prod) {
                    var_dump($prod->getId()." Producto duplicado");
                }
                $producto = $productos[0];
            }
                
        }

        return $producto;
    }
    /**
     * Hay que elegir uno de los dos productos:
     *          1. Si uno tiene alguno de los codigos y el otro no. Se selecciona ese y se migra el otro
     *          2. Si los dos tienen codigos en diferentes campos, se selecciona el primero y se migra el segundo actualizando el primero con el campo faltante
     *          3. Si los dos tienen codigos diferentes en el mismo campo, lanza excepcion
     * 
     */
    private function fusionarProductos($productos) {

        $seleccionado = null;
        $modelos = [];
        
        foreach ($productos as $prd) {
            /** Si tiene código */
            $modelos[] = $prd->getModelo();
            
            if ($seleccionado == null) {
                $seleccionado = $prd;
                continue;
            }

            if ($prd->hasCode()) {
                if (!$seleccionado->hasCode()) { 
                    /** Caso 1 */
                    $seleccionado = $prd;
                    $this->mergeRelations($seleccionado, $prd);
                } else {
                    /** Caso 2 */
                    $seleccionado->mergeCodes($prd);
                    $this->mergeRelations($seleccionado, $prd);
                }
            }
        }

        $seleccionado->addModelos();

        return $seleccionado;
    }

    private function mergeRelations($prd1, $prd2) {

        $publicaciones = $this->em->getRepository(PublicacionML::class)->findBy(["producto" => $prd2->getId()]);

        foreach ($publicaciones as $publi) {
            $publi->setProducto($prd1);
            $this->em->persist($publi);
        }

        $publicaciones = $this->em->getRepository(PublicacionPropia::class)->findBy(["producto" => $prd2->getId()]);

        foreach ($publicaciones as $publi) {
            $publi->setProducto($prd1);
            $this->em->persist($publi);
        }

        $publicaciones = $this->em->getRepository(PublicacionEbay::class)->findBy(["producto" => $prd2->getId()]);

        foreach ($publicaciones as $publi) {
            $publi->setProducto($prd1);
            $this->em->persist($publi);
        }

        $this->em->remove($prd2);
    }

    private function comprimirTexto($text) {
        $text = strtoupper($text);
        $text = str_replace(' ', '', $text);
        $text = str_replace('-', '', $text);
        $text = str_replace('_', '', $text);
        $text = str_replace('\'', '', $text);
        return $text;
    }

    private function imprimo($texto) {
        echo "\n".date("Y-m-d H:i:s"). " ****** ".$texto;
    }
}