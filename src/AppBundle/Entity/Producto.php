<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto
{
    const ORM_ENTITY = "AppBundle:Producto";
    const NO_ESTA_CODIGO = "NO_ESTA";
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria_interna", type="string", length=255, nullable=true)
     */
    private $categoria_interna;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria_match_ml", type="string", length=255, nullable=true)
     */
    private $categoria_match_ml;

    /**
     * @var string
     *
     * @ORM\Column(name="rotacion", type="string", length=255, nullable=true)
     */
    private $rotacion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="peso", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $peso;

    /**
     * @var string
     *
     * @ORM\Column(name="peso_caja", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $peso_caja;

    /**
     * @var string
     *
     * @ORM\Column(name="ancho", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $ancho;

    /**
     * @var string
     *
     * @ORM\Column(name="largo", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $largo;

    /**
     * @var string
     *
     * @ORM\Column(name="profundidad", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $profundidad;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_minimo", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $precio_minimo;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_maximo", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $precio_maximo;
    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255, nullable=true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=255, nullable=true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo2", type="string", length=255, nullable=true)
     */
    private $modelo2;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo3", type="string", length=255, nullable=true)
     */
    private $modelo3;

    /**
     * @var string
     *
     * @ORM\Column(name="ean", type="bigint", nullable=true)
     */
    private $ean;

    /**
     * @var string
     *
     * @ORM\Column(name="mpn", type="string", length=255, nullable=true)
     */
    private $mpn;

    /**
     * @var string
     *
     * @ORM\Column(name="upc", type="bigint", nullable=true)
     */
    private $upc;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido_paquete", type="string", length=610, nullable=true)
     */
    private $contenido_paquete;


    /**
     * @var string
     *
     * @ORM\Column(name="web_oficial", type="string", length=255, nullable=true)
     */
    private $web_oficial;

    /**
     * @var string
     *
     * @ORM\Column(name="manual_url", type="string", length=255, nullable=true)
     */
    private $manual_url;

    /**
     * @var string
     *
     * @ORM\Column(name="origen", type="string", length=255, nullable=true)
     */
    private $origen;



    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Producto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Producto
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Producto
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Producto
     */
    public function setCantidad($cantidad = 0)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function __toString() {
        $aux = "";
        
        if ($this->getMarca() != null) {
            $aux .= $this->getMarca();
        }
        $aux .= "_";

        if ($this->getModelo() != null) {
            $aux .= $this->getModelo();
        } 

        return $aux;
        
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Producto
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set categoriaInterna
     *
     * @param string $categoriaInterna
     *
     * @return Producto
     */
    public function setCategoriaInterna($categoriaInterna)
    {
        $this->categoria_interna = $categoriaInterna;

        return $this;
    }

    /**
     * Get categoriaInterna
     *
     * @return string
     */
    public function getCategoriaInterna()
    {
        return $this->categoria_interna;
    }

    /**
     * Set categoriaMatchMl
     *
     * @param string $categoriaMatchMl
     *
     * @return Producto
     */
    public function setCategoriaMatchMl($categoriaMatchMl)
    {
        $this->categoria_match_ml = $categoriaMatchMl;

        return $this;
    }

    /**
     * Get categoriaMatchMl
     *
     * @return string
     */
    public function getCategoriaMatchMl()
    {
        return $this->categoria_match_ml;
    }

    /**
     * Set rotacion
     *
     * @param string $rotacion
     *
     * @return Producto
     */
    public function setRotacion($rotacion)
    {
        $this->rotacion = $rotacion;

        return $this;
    }

    /**
     * Get rotacion
     *
     * @return string
     */
    public function getRotacion()
    {
        return $this->rotacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set peso
     *
     * @param string $peso
     *
     * @return Producto
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set pesoCaja
     *
     * @param string $pesoCaja
     *
     * @return Producto
     */
    public function setPesoCaja($pesoCaja)
    {
        $this->peso_caja = $pesoCaja;

        return $this;
    }

    /**
     * Get pesoCaja
     *
     * @return string
     */
    public function getPesoCaja()
    {
        return $this->peso_caja;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     *
     * @return Producto
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set largo
     *
     * @param string $largo
     *
     * @return Producto
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set profundidad
     *
     * @param string $profundidad
     *
     * @return Producto
     */
    public function setProfundidad($profundidad)
    {
        $this->profundidad = $profundidad;

        return $this;
    }

    /**
     * Get profundidad
     *
     * @return string
     */
    public function getProfundidad()
    {
        return $this->profundidad;
    }

    /**
     * Set precioMinimo
     *
     * @param string $precioMinimo
     *
     * @return Producto
     */
    public function setPrecioMinimo($precioMinimo)
    {
        $this->precio_minimo = $precioMinimo;

        return $this;
    }

    /**
     * Get precioMinimo
     *
     * @return string
     */
    public function getPrecioMinimo()
    {
        return $this->precio_minimo;
    }

    /**
     * Set precioMaximo
     *
     * @param string $precioMaximo
     *
     * @return Producto
     */
    public function setPrecioMaximo($precioMaximo)
    {
        $this->precio_maximo = $precioMaximo;

        return $this;
    }

    /**
     * Get precioMaximo
     *
     * @return string
     */
    public function getPrecioMaximo()
    {
        return $this->precio_maximo;
    }

    /**
     * Set modelo2
     *
     * @param string $modelo2
     *
     * @return Producto
     */
    public function setModelo2($modelo2)
    {
        $this->modelo2 = $modelo2;

        return $this;
    }

    /**
     * Get modelo2
     *
     * @return string
     */
    public function getModelo2()
    {
        return $this->modelo2;
    }

    /**
     * Set modelo3
     *
     * @param string $modelo3
     *
     * @return Producto
     */
    public function setModelo3($modelo3)
    {
        $this->modelo3 = $modelo3;

        return $this;
    }

    /**
     * Get modelo3
     *
     * @return string
     */
    public function getModelo3()
    {
        return $this->modelo3;
    }

    /**
     * Set contenidoPaquete
     *
     * @param string $contenidoPaquete
     *
     * @return Producto
     */
    public function setContenidoPaquete($contenidoPaquete)
    {
        $this->contenido_paquete = $contenidoPaquete;

        return $this;
    }

    /**
     * Get contenidoPaquete
     *
     * @return string
     */
    public function getContenidoPaquete()
    {
        return $this->contenido_paquete;
    }

    /**
     * Set webOficial
     *
     * @param string $webOficial
     *
     * @return Producto
     */
    public function setWebOficial($webOficial)
    {
        $this->web_oficial = $webOficial;

        return $this;
    }

    /**
     * Get webOficial
     *
     * @return string
     */
    public function getWebOficial()
    {
        return $this->web_oficial;
    }

    /**
     * Set manualUrl
     *
     * @param string $manualUrl
     *
     * @return Producto
     */
    public function setManualUrl($manualUrl)
    {
        $this->manual_url = $manualUrl;

        return $this;
    }

    /**
     * Get manualUrl
     *
     * @return string
     */
    public function getManualUrl()
    {
        return $this->manual_url;
    }

    /**
     * Set origen
     *
     * @param string $origen
     *
     * @return Producto
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set ean
     *
     * @param integer $ean
     *
     * @return Producto
     */
    public function setEan($ean)
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * Get ean
     *
     * @return integer
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set mpn
     *
     * @param string $mpn
     *
     * @return Producto
     */
    public function setMpn($mpn)
    {
        $this->mpn = $mpn;

        return $this;
    }

    /**
     * Get mpn
     *
     * @return string
     */
    public function getMpn()
    {
        return $this->mpn;
    }

    /**
     * Set upc
     *
     * @param integer $upc
     *
     * @return Producto
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;

        return $this;
    }

    /**
     * Get upc
     *
     * @return integer
     */
    public function getUpc()
    {
        return $this->upc;
    }
}
