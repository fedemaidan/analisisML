<?php

namespace AppBundle\Utils\Publicador;

use AppBundle\Entity\PublicacionPropia;
use AppBundle\Utils\Meli\Meli;

class PublicadorAbstract {

    const DOLAR = 45;

    protected $producto;
    protected $ebay;
    protected $comoYouTec;

    public function __construct( $comoYouTec, $producto, $ebay = null)
    {
        $this->producto = $producto;
        $this->ebay = $ebay;
        $this->comoYouTec = $comoYouTec;
    }

    public function actualizarPublicacion($publicacion) {
        try{
            return $this->getPublicacion($publicacion->getCuenta(),$publicacion);
        }
        catch (\Exception $e) {
            var_dump("Error en ".$pubcacion->getId()." ".$e->getMessage());
        }
    }

    public function getPublicacion($cuentaMl, $publicacion = null) {
        
       // $titulo = $this->getTitulo();
        $descripcion = $this->getDescripcion();
       // $precio = $this->getPrecio();
       // $imagenes = $this->getImagenes();
       // $atributos = $this->getAtributos();
       // $video = $this->producto ? $this->producto->getYoutube() : "";

        if (!$publicacion)
            $publicacion = new PublicacionPropia();
        
        //$publicacion->setTitulo($titulo);
        $publicacion->setDescripcion($descripcion);
        //$publicacion->setPrecioCompra($precio);
        //$publicacion->setImagenes($imagenes);
        //$publicacion->setAtributos($atributos);
        //$publicacion->setVideo($video);
        
        if ($this->ebay)
            $publicacion->setPublicacionEbay($this->ebay);

        //$publicacion->setCuenta($cuentaMl);

        //$categoriaML = $this->getCategoriaML($publicacion);
        //$publicacion->setCategoriaML($categoriaML);
        
        //$publicacion->setComoYoutec($this->comoYouTec);
        $publicacion->setTipoDeVenta($this->getTipoDeVenta());

        return $publicacion;
    }

    protected function getTituloEbay() {
        $ebay = $this->ebay;

        if ($ebay != null) {
            $texto = $ebay->getTitulo();
        }

        $nombreCategoria = $ebay->getCategoriaEbay()->getName();  

        if (strpos($nombreCategoria, 'Watch') !== false) {
            $texto = "SmartWatch ".$texto;
        }

        $sufijo  = $this->getSufijo();
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        
        return $texto.$sufijo;
    }

    protected function getTituloProducto() {
        $texto = $this->producto->getNombre();
        $texto = $this->producto->getCategoriaMl()->getNombre()." ".$texto;
        $sufijo  = $this->getSufijo();

        if ($this->comoYouTec)
            $sufijo .= " YouTec";
        
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        return $texto.$sufijo;
    }

    protected function getPrecioEbay() {
        $categoria = $this->ebay->getCategoriaEbay();
        $precioCompra = $this->ebay->getPrecioCompra();
        $ratio = $categoria->getRatio();
        $shipping = $categoria->getShipping();
        $precio = (($precioCompra * $ratio) + $shipping) * self::DOLAR;
        return $this->precioComercial($precio);
    }

    protected function getSufijo() {
        $sufijo = "";
        
        if ($this->producto){
            foreach ($this->producto->getCategorias() as $key => $cate) {
                $sufijo .= " ".$cate->getNombre();
            }
        }
        return $sufijo;
    }


    public function getDescripcion() {
        $productoTexto = $this->getProductoTexto();

        $youtecTexto = "";

        if ($this->comoYouTec) {
            $youtecTexto = "-Somos YOUTEC, el Futuro está en tus manos-";
        }

        $tipoPrincipioTexto = $this->getTipoPrincipioTexto();
        return  $youtecTexto."
".$tipoPrincipioTexto."
".$productoTexto."
------------------------------------------
•Medios de Pago:
+Aceptamos Todos los medio de pago de Mercado Pago
+Efectivo y Transferencia Bancaria (¡Consultá por Bonificaciones!)
------------------------------------------
•RETIRO
+Nos encontramos en Flores, CABA. 
+Nuestro Horario de Atención es de 8 a 20. Los RETIROS son con Horario coordinado previamente.

•ENVÍOS 
+Realizamos Envíos a TODO el PAÍS
------------------------------------------
•GARANTÍA
+Todos nuestros Productos tienen GARANTÍA DE SEIS MESES ante cualquier Falla de Fábrica

".$youtecTexto;
    }

    protected function getProductoTexto() {
        $productoTexto = "";
        if ($this->producto) {
            $productoTexto = "Características Técnicas y Especificaciones del Producto:";

            foreach ($this->producto->getAtributos() as $key => $attr) {
                $productoTexto .=  "
                - ".$attr;
            }

            $productoTexto = "--------------------------------------------
            Descripción del producto:

            ".$this->producto->getDescripcion()."
            ";
        }
        
        return $productoTexto;       
    }

    public function getPrecio() {
        if ($this->producto){
            $ajuste = $this->getAjuste();
            $precio = $this->producto->getPrecioReferencia() * $ajuste;
            return $this->precioComercial($precio);
        }
        else
            return $this->getPrecioEbay();
    }

    public function getTitulo() {
        if ($this->producto)
            return $this->getTituloProducto();
        else
            return $this->getTituloEbay();
    }

    public function getAjuste() {
        return 1;
    }

    public function precioComercial($precio) {
        return intdiv($precio, 100) * 100 - 1;
    }

    public function getImagenes() {
        if ($this->producto)
            return $this->producto->getImagenes();
        else if ($this->ebay)
            return $this->ebay->getImagenes();
    }

    public function getCategoriaML($publicacion) {
        if ($this->producto)
            return $this->producto->getCategoriaMl()->getIdMl();
        else
            return $this->predecirCategoria($publicacion);
    }

    protected function predecirCategoria($publicacion) {
        if ($publicacion->getPublicacionEbay() ) {
            $nombreCategoria = $publicacion->getPublicacionEbay()->getCategoriaEbay()->getName();  
            if (strpos($nombreCategoria, 'Watch') !== false) {
                return "MLA399230";
            }    
        }

        $category_from = "MLA1276";

        $meli = new Meli("","");
        $titulo = str_replace("&", " ", $publicacion->getTitulo());
        $titulo = str_replace("\"", " ", $titulo);
        $titulo = str_replace(" ", "%20", $titulo);
        
        $url = "sites/MLA/category_predictor/predict?&title='".$titulo."'&seller_id=".$publicacion->getCuenta()->getIdMl()."&price=".$publicacion->getPrecioCompra()."&category_from=".$category_from;
        
        $url = str_replace(" ", "%", $url);

        $datos = $meli->get($url);
        
        if ( property_exists($datos["body"], "id") ) {
            return $datos["body"]->id;
        } else {
            return null;
        }       
    }

    public function getAtributos() {
        return $this->producto ? $this->producto->getAtributos() : null;
    }

} 