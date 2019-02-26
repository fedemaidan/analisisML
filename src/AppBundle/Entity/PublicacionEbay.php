<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicacionEbay
 *
 * @ORM\Table(name="publicacion_ebay")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicacionEbayRepository")
 */
class PublicacionEbay
{
    const ORM_ENTITY = "AppBundle:PublicacionEbay";

     public function __construct() {
        $this->especificaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @ORM\Column(name="id_ebay", type="string", unique=true, length=255)
     */
    private $idEbay;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_compra", type="decimal", precision=7, scale=2)
     */
    private $precio_compra;

    /**
     * @var string
     *
     * @ORM\Column(name="link_publicacion", type="string", length=255, nullable=true)
     */
    private $linkPublicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="vendedor", type="string", length=255, nullable=true)
     */
    private $vendedor;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255, nullable=true)
     */
    private $model;

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
     * @ORM\Column(name="ean", type="bigint", nullable=true)
     */
    private $ean;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenes", type="string", length=1500, nullable=true)
     */
    private $imagenes;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad_vendidos_ebay", type="integer")
     */
    private $cantidadVendidosEbay;

    /**
     * @var categoriaEbay
     * @ORM\ManyToOne(targetEntity="CategoriaEbay")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaEbay;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado_ebay", type="string", length=255)
     */
    private $estado_ebay;

    /**
     * @ORM\ManyToMany(targetEntity="EspecificacionesProductoEbay", inversedBy="publicacionesEbay")
     * @ORM\JoinTable(name="publicaciones_espeficaciciones_ebay")
     */
    private $especificaciones;


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
     * Set idEbay
     *
     * @param string $idEbay
     *
     * @return PublicacionEbay
     */
    public function setIdEbay($idEbay)
    {
        $this->idEbay = $idEbay;

        return $this;
    }

    /**
     * Get idEbay
     *
     * @return string
     */
    public function getIdEbay()
    {
        return $this->idEbay;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return PublicacionEbay
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set precio_compra
     *
     * @param string $precio_compra
     *
     * @return PublicacionEbay
     */
    public function setPrecioCompra($precio)
    {
        $this->precio_compra = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecioCompra()
    {
        return $this->precio_compra;
    }

    /**
     * Set linkPublicacion
     *
     * @param string $linkPublicacion
     *
     * @return PublicacionEbay
     */
    public function setLinkPublicacion($linkPublicacion)
    {
        $this->linkPublicacion = $linkPublicacion;

        return $this;
    }

    /**
     * Get linkPublicacion
     *
     * @return string
     */
    public function getLinkPublicacion()
    {
        return $this->linkPublicacion;
    }

    /**
     * Set imagenes
     *
     * @param string $imagenes
     *
     * @return PublicacionEbay
     */
    public function setImagenes($imagenes)
    {
        $this->imagenes = $imagenes;

        return $this;
    }

    /**
     * Get imagenes
     *
     * @return string
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }

    /**
     * Set cantidadVendidosEbay
     *
     * @param string $cantidadVendidosEbay
     *
     * @return PublicacionEbay
     */
    public function setCantidadVendidosEbay($cantidadVendidosEbay)
    {
        $this->cantidadVendidosEbay = $cantidadVendidosEbay;

        return $this;
    }

    /**
     * Get cantidadVendidosEbay
     *
     * @return string
     */
    public function getCantidadVendidosEbay()
    {
        return $this->cantidadVendidosEbay;
    }

    /**
     * Get json
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set vendedor
     *
     * @param string $vendedor
     *
     * @return PublicacionEbay
     */
    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    /**
     * Get json
     *
     * @return string
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    public function getImagenesFoto() {
        $ima = explode(',', $this->getImagenes());
        $retornar = "";
        foreach ($ima as $key => $value) {
            $retornar .= "<img src='".$value."'></img>";
        }
        return $retornar;
    }

    public function getImagenPrincipal() {
        return "<img src='".$this->getImagenUrlByIndex(0)."'></img>";
    }

    public function getImagenUrlByIndex($i) {
        $ima = explode(',', $this->getImagenes());
        if (count($ima) > $i)
            return $ima[$i];
        return "";
    }


    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return PublicacionEbay
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Set estadoEbay
     *
     * @param string $estadoEbay
     *
     * @return PublicacionEbay
     */
    public function setEstadoEbay($estadoEbay)
    {
        $this->estado_ebay = $estadoEbay;

        return $this;
    }

    /**
     * Get estadoEbay
     *
     * @return string
     */
    public function getEstadoEbay()
    {
        return $this->estado_ebay;
    }

    /**
     * Set categoriaEbay
     *
     * @param \AppBundle\Entity\CategoriaEbay $categoriaEbay
     *
     * @return PublicacionEbay
     */
    public function setCategoriaEbay(\AppBundle\Entity\CategoriaEbay $categoriaEbay = null)
    {
        $this->categoriaEbay = $categoriaEbay;

        return $this;
    }

    /**
     * Get categoriaEbay
     *
     * @return \AppBundle\Entity\CategoriaEbay
     */
    public function getCategoriaEbay()
    {
        return $this->categoriaEbay;
    }


    public function getEspecificaciones() {
        return $this->especificaciones;
    }

    public function setEspecificaciones($especificaciones) {
        return $this->especificaciones = $especificaciones;
    }

    public function addEspeficicaciones($espe) {
        $this->especificaciones[] = $espe;
    }


    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return PublicacionEbay
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add especificacione
     *
     * @param \AppBundle\Entity\EspecificacionesProductoEbay $especificacione
     *
     * @return PublicacionEbay
     */
    public function addEspecificacione(\AppBundle\Entity\EspecificacionesProductoEbay $especificacione)
    {
        $this->especificaciones[] = $especificacione;

        return $this;
    }

    /**
     * Remove especificacione
     *
     * @param \AppBundle\Entity\EspecificacionesProductoEbay $especificacione
     */
    public function removeEspecificacione(\AppBundle\Entity\EspecificacionesProductoEbay $especificacione)
    {
        $this->especificaciones->removeElement($especificacione);
    }

    /* Funciones para el excel */

    public function getImagen0() {
        return $this->getImagenUrlByIndex(0);
    }

    public function getImagen1() {
        return $this->getImagenUrlByIndex(1);
    }

    public function getImagen2() {
        return $this->getImagenUrlByIndex(2);
    }

    public function getImagen3() {
        return $this->getImagenUrlByIndex(3);
    }

    public function getImagen4() {
        return $this->getImagenUrlByIndex(4);
    }

    public function getImagen5() {
        return $this->getImagenUrlByIndex(5);
    }

    public function getImagen6() {
        return $this->getImagenUrlByIndex(6);
    }

    public function getImagen7() {
        return $this->getImagenUrlByIndex(7);
    }

    public function getDescripcion() {
        return "Descripción";
    }


    /**
     * Set model
     *
     * @param string $model
     *
     * @return PublicacionEbay
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set mpn
     *
     * @param string $mpn
     *
     * @return PublicacionEbay
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
     * @param string $upc
     *
     * @return PublicacionEbay
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;

        return $this;
    }

    /**
     * Get upc
     *
     * @return string
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * Set ean
     *
     * @param integer $ean
     *
     * @return PublicacionEbay
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


    public function __toString() {
        return $this->id." - ".$this->titulo;
    }
}
