<?php

namespace AppBundle\Utils\Publicador;

use AppBundle\Entity\PublicacionPropia;

class PublicadorAbstract {	

    protected $producto;
    protected $ebay;
    protected $comoYouTec;

    public function __construct( $comoYouTec, $producto, $ebay = null)
    {
        $this->producto = $producto;
        $this->ebay = $ebay;
        $this->comoYouTec = $comoYouTec;
    }


    public function crearPublicacion() {
        
        $titulo = $this->getTitulo();
        $descripcion = $this->getDescripcion();
        $precio = $this->getPrecio();
        $imagenes = $this->getImagenes();
        $atributos = $this->getAtributos();
        $publicacion = new PublicacionPropia();
        $publicacion->setTitulo($titulo);
        $publicacion->setDescripcion($descripcion);
        $publicacion->setPrecioCompra($precio);
        $publicacion->setImagenes($imagenes);

        $categoriaML = $this->getCategoriaML($publicacion);
        $publicacion->setCategoriaML($categoriaML);
        return $publicacion;
    }

    protected function getTituloEbay() {
        $ebay = $this->getPublicacionEbay();

        if ($ebay != null) {
            $brand = $ebay->getBrand();
            $model = $ebay->getModel();

            if ($model && $model != "")
                $texto = $brand." ".$model;
            else
                $texto = $ebay->getTitulo();
        }

        $nombreCategoria = $ebay->getCategoriaEbay()->getName();  

        if (strpos($nombreCategoria, 'Watch') !== false) {
            $texto = "SmartWatch ".$texto;
        }

        $sufijo  = $this->getSufijo();
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        
        $this->setTitulo($texto.$sufijo);
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
        $categoria = $this->getPublicacionEbay()->getCategoriaEbay();
        $precioCompra = $this->getPublicacionEbay()->getPrecioCompra();
        $ratio = $categoria->getRatio();
        $shipping = $categoria->getShipping();
        $precio = (($precioCompra * $ratio) + $shipping) * self::DOLAR;
        return $this->precioComercial($precio);
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
        else
            return $this->ebay->getImagenes();
    }

    public function getCategoriaML($publicacion) {
        if ($this->producto)
            return $this->producto->getCategoriaMl()->getIdMl();
        else
            return $this->predecirCategoria($publicacion);
    }

    private function predecirCategoria($publicacion) {
        $nombreCategoria = $publicacion->getPublicacionEbay()->getCategoriaEbay()->getName();  
        if (strpos($nombreCategoria, 'Watch') !== false) {
            return "MLA399230";
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