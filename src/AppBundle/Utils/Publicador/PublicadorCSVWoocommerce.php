<?php

namespace AppBundle\Utils\Publicador;

use AppBundle\Entity\PublicacionPropia;
class PublicadorCSVWoocommerce extends PublicadorAbstract {	

    protected $row;
    protected $comoYouTec;

    public function __construct( $comoYouTec, $row)
    {
        $this->row = $row;
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
        
        $titulo = $this->getTituloWoocommerce();
        $descripcion = $this->getDescripcion();
        $precio = $this->row["precio"] * 1.1;
        $imagenes = $this->row["imagenes"];
        
        //$atributos = $this->getAtributos();
        //$video = $this->producto ? $this->producto->getYoutube() : "";

        if (!$publicacion)
            $publicacion = new PublicacionPropia();
        
        $publicacion->setTitulo($titulo);
        $publicacion->setDescripcion($descripcion);
        $publicacion->setPrecioCompra($precio);
        $publicacion->setImagenes($imagenes);
        //$publicacion->setAtributos($atributos);
        //$publicacion->setVideo($video);
        $publicacion->setCuenta($cuentaMl);

        $categoriaML = $this->predecirCategoria($publicacion);
        $publicacion->setCategoriaML($categoriaML);
        
        $publicacion->setComoYoutec($this->comoYouTec);
        $publicacion->setTipoDeVenta($this->getTipoDeVenta());

        return $publicacion;
    }

    protected function getTipoPrincipioTexto() {
        return "CONSULTAR TIEMPO DE ENTREGA -- YOUTEC AR 
        ------------------------------------------
        ";
    }

    public function getTipoDeVenta() {
        return $this->row["tipoVenta"];
    }

    protected function getProductoTexto() {
        $productoTexto = "";
        

        $productoTexto = "--------------------------------------------
        Descripción del producto:

        ".$this->row["descripcion"]."
        ";
    
        return $productoTexto;       
    }

    protected function getTituloWoocommerce() {
        $texto = $this->row["titulo"];
        $categorias = str_replace(",", "", $this->row["categorias"]);
        $texto = $texto." ".$categorias;
        $sufijo = $this->getSufijo();

        if ($this->comoYouTec)
            $sufijo .= " YOUTEC AR";
        
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        return $texto.$sufijo;
    }

}