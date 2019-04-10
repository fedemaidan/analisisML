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

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var bool
     *
     * @ORM\Column(name="destacado", type="boolean", nullable=true)
     */
    private $destacado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="youtube", type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenes", type="string", length=4080, nullable=true)
     */
    private $imagenes;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_referencia", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $precioReferencia;

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
     * @ORM\Column(name="modelo4", type="string", length=255, nullable=true)
     */
    private $modelo4;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo5", type="string", length=255, nullable=true)
     */
    private $modelo5;

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
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @ORM\ManyToMany(targetEntity="AtributoML", inversedBy="producto")
     */
    private $atributos;

    /**
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="producto")
     */
    private $categorias;

    /**
     * @ORM\OneToMany(targetEntity="PublicacionML", mappedBy="producto")
     */
    private $competencia;

    /**
     * @ORM\OneToMany(targetEntity="PublicacionPropia", mappedBy="producto")
     */
    private $publicaciones;


    /**
     * @ORM\OneToMany(targetEntity="PublicacionEbay", mappedBy="producto")
     */
    private $proveedores;
    /**
     * @var CategoriaML
     * @ORM\ManyToOne(targetEntity="CategoriaML")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaMl;


    /**
     * @var CategoriaEbay
     * @ORM\ManyToOne(targetEntity="CategoriaEbay")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaEbay;

    /**
     * @var string
     *
     * @ORM\Column(name="woocommerce_id", type="string", length=255, nullable=true)
     */
    private $woocommerceId;

    /**
     * Get id
     *
     * @return integer
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
     * Set precioReferencia
     *
     * @param float $precioReferencia
     *
     * @return Producto
     */
    public function setPrecioReferencia($precioReferencia)
    {
        $this->precioReferencia = $precioReferencia;

        return $this;
    }

    /**
     * Get precioReferencia
     *
     * @return float
     */
    public function getPrecioReferencia()
    {
        return $this->precioReferencia;
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
     * Set modelo4
     *
     * @param string $modelo4
     *
     * @return Producto
     */
    public function setModelo4($modelo4)
    {
        $this->modelo4 = $modelo4;

        return $this;
    }

    /**
     * Get modelo4
     *
     * @return string
     */
    public function getModelo4()
    {
        return $this->modelo4;
    }

    /**
     * Set modelo5
     *
     * @param string $modelo5
     *
     * @return Producto
     */
    public function setModelo5($modelo5)
    {
        $this->modelo5 = $modelo5;

        return $this;
    }

    /**
     * Get modelo5
     *
     * @return string
     */
    public function getModelo5()
    {
        return $this->modelo5;
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

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Producto
     */
    public function setCantidad($cantidad)
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->atributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add atributo
     *
     * @param \AppBundle\Entity\AtributoML $atributo
     *
     * @return Producto
     */
    public function addAtributo(\AppBundle\Entity\AtributoML $atributo)
    {
        $this->atributos[] = $atributo;

        return $this;
    }

    /**
     * Remove atributo
     *
     * @param \AppBundle\Entity\AtributoML $atributo
     */
    public function removeAtributo(\AppBundle\Entity\AtributoML $atributo)
    {
        $this->atributos->removeElement($atributo);
    }

    /**
     * Get atributos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAtributos()
    {
        return $this->atributos;
    }

    public function mergeCodes($prd) {
        $upc = $this->correctCode($this->getUpc(), $prd->getUpc(),true);
        $mpn = $this->correctCode($this->getMpn(), $prd->getMpn(),false);
        $ean = $this->correctCode($this->getEan(), $prd->getEan(),false);

        $this->setUpc($upc);
        $this->setMpn($mpn);
        $this->setEan($ean);
    }

    public function correctCode($code1, $code2,$exception) {
        if ($code1 == null) {
            return $code2;
        }
        
        if ($code2 == null) {
            return $code1;
        }

        if ($code1 == $code2) {
            return $code1;
        } else {
            if ($exception)
                throw new \Exception("$code1 distinto $code2");
            else
                return $code1;
        }
    }

    public function hasCode() {
        return $this->getUpc() || $this->getMpn() || $this->getEan();
    }

    public function addModelos($modelos) {
        if ($modelos[0])
            $this->modelo = $modelos[0];
        if ($modelos[1])
            $this->modelo2 = $modelos[1];
        if ($modelos[2])
            $this->modelo3 = $modelos[2];
        if ($modelos[3])
            $this->modelo4 = $modelos[3];
        if ($modelos[4])
            $this->modelo5 = $modelos[4];
    }    


    /**
     * Set categoriaMl
     *
     * @param \AppBundle\Entity\CategoriaML $categoriaMl
     *
     * @return Producto
     */
    public function setCategoriaMl(\AppBundle\Entity\CategoriaML $categoriaMl = null)
    {
        $this->categoriaMl = $categoriaMl;

        return $this;
    }

    /**
     * Get categoriaMl
     *
     * @return \AppBundle\Entity\CategoriaML
     */
    public function getCategoriaMl()
    {
        return $this->categoriaMl;
    }

    /**
     * Set categoriaEbay
     *
     * @param \AppBundle\Entity\CategoriaEbay $categoriaEbay
     *
     * @return Producto
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

    /**
     * Add competencium
     *
     * @param \AppBundle\Entity\PublicacionML $competencium
     *
     * @return Producto
     */
    public function addCompetencium(\AppBundle\Entity\PublicacionML $competencium)
    {
        $this->competencia[] = $competencium;

        return $this;
    }

    /**
     * Remove competencium
     *
     * @param \AppBundle\Entity\PublicacionML $competencium
     */
    public function removeCompetencium(\AppBundle\Entity\PublicacionML $competencium)
    {
        $this->competencia->removeElement($competencium);
    }

    /**
     * Get competencia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Add publicacione
     *
     * @param \AppBundle\Entity\PublicacionPropia $publicacione
     *
     * @return Producto
     */
    public function addPublicacione(\AppBundle\Entity\PublicacionPropia $publicacione)
    {
        $this->publicaciones[] = $publicacione;

        return $this;
    }

    /**
     * Remove publicacione
     *
     * @param \AppBundle\Entity\PublicacionPropia $publicacione
     */
    public function removePublicacione(\AppBundle\Entity\PublicacionPropia $publicacione)
    {
        $this->publicaciones->removeElement($publicacione);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }

    /**
     * Add proveedore
     *
     * @param \AppBundle\Entity\PublicacionEbay $proveedore
     *
     * @return Producto
     */
    public function addProveedore(\AppBundle\Entity\PublicacionEbay $proveedore)
    {
        $this->proveedores[] = $proveedore;

        return $this;
    }

    /**
     * Remove proveedore
     *
     * @param \AppBundle\Entity\PublicacionEbay $proveedore
     */
    public function removeProveedore(\AppBundle\Entity\PublicacionEbay $proveedore)
    {
        $this->proveedores->removeElement($proveedore);
    }

    /**
     * Get proveedores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProveedores()
    {
        return $this->proveedores;
    }
    

//trait
public function getImagenesFoto() {
    $ima = explode(',', $this->getImagenes());
    $retornar = "";
    foreach ($ima as $key => $value) {
        $retornar .= "<img src='".$value."'></img>";
    }
    return $retornar;
}

public function getImagenUrlByIndex($i) {
    $ima = explode(',', $this->getImagenes());
    if (count($ima) > $i)
        return $ima[$i];
    return "";
}

public function getImagenPrincipal() {
    return "<img src='".$this->getImagenUrlByIndex(0)."'></img>";
}

    /**
     * Set destacado
     *
     * @param boolean $destacado
     *
     * @return Producto
     */
    public function setDestacado($destacado)
    {
        $this->destacado = $destacado;

        return $this;
    }

    /**
     * Get destacado
     *
     * @return boolean
     */
    public function getDestacado()
    {
        return $this->destacado;
    }

    public function getCantidadCompetidores() {
        return count($this->getCompetencia());
    }

    public function getVentasCompetidores() {
        $aux = 0;
        foreach ($this->getCompetencia() as $publi) {
            $aux += $publi->getCantidadVendidos();
        }
        return $aux;
    }

    public function getPrecioProveedores() {
        $min = 9999999999;
        foreach ($this->getProveedores() as $publi) {
            if ($min > $publi->getPrecioCompra())
                $min = $publi->getPrecioCompra();
        }
        return $min;
    }

    /**
     * Set imagenes
     *
     * @param string $imagenes
     *
     * @return Producto
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
     * Add categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     *
     * @return Producto
     */
    public function addCategoria(\AppBundle\Entity\Categoria $categoria)
    {
        $this->categorias[] = $categoria;

        return $this;
    }

    /**
     * Remove categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     */
    public function removeCategoria(\AppBundle\Entity\Categoria $categoria)
    {
        $this->categorias->removeElement($categoria);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set youtube
     *
     * @param string $youtube
     *
     * @return Producto
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return string
     */
    public function getYoutube()
    {
        return $this->youtube;
    }
}
