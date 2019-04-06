<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs\PreUpdateEventArgs;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PublicacionrPropia
 *
 * @ORM\Table(name="publicacion_propia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicacionPropiaRepository")
 */
class PublicacionPropia 
{

    use Traits\PublicacionMLTrait;

	/**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

	/**
     * @var cuenta
     * @ORM\ManyToOne(targetEntity="Cuenta")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cuenta;	  

    /**
     * @var PublicacionEbay
     * @ORM\ManyToOne(targetEntity="PublicacionEbay")
     * @ORM\JoinColumn(nullable=true)
     */
    private $publicacion_ebay;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     * @Assert\Choice({"closed", "paused", "active"})
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="woocommerce_id", type="string", length=255, nullable=true)
     */
    private $woocommerceId;

    
    public $notificar_ml = true;

    /**
     * @ORM\ManyToMany(targetEntity="AtributoML", inversedBy="publicacionPropia")
     * @ORM\JoinTable(name="publicaciones_propias_atributos_ml")
     */
    private $atributos;

    /**
     * @var bool
     *
     * @ORM\Column(name="destacado", type="boolean", nullable=true)
     */
    private $destacado;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return PublicacionPropia
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
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return PublicacionPropia
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \AppBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set publicacionEbay
     *
     * @param \AppBundle\Entity\PublicacionEbay $publicacionEbay
     *
     * @return PublicacionPropia
     */
    public function setPublicacionEbay(\AppBundle\Entity\PublicacionEbay $publicacionEbay = null)
    {
        $this->publicacion_ebay = $publicacionEbay;

        return $this;
    }

    /**
     * Get publicacionEbay
     *
     * @return \AppBundle\Entity\PublicacionEbay
     */
    public function getPublicacionEbay()
    {
        return $this->publicacion_ebay;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return PublicacionPropia
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set woocommerceId
     *
     * @param string $woocommerceId
     *
     * @return PublicacionPropia
     */
    public function setWoocommerceId($woocommerceId)
    {
        $this->woocommerceId = $woocommerceId;

        return $this;
    }

    /**
     * Get woocommerceId
     *
     * @return string
     */
    public function getWoocommerceId()
    {
        return $this->woocommerceId;
    }

    /**
     * Set filtrarNew
     *
     * @param boolean $filtrarNew
     *
     * @return PublicacionPropia
     */
    public function setFiltrarNew($filtrarNew)
    {
        $this->filtrarNew = $filtrarNew;

        return $this;
    }

    /**
     * Get filtrarNew
     *
     * @return boolean
     */
    public function getFiltrarNew()
    {
        return $this->filtrarNew;
    }

    /**
     * Set destacado
     *
     * @param boolean $destacado
     *
     * @return PublicacionPropia
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


    public function getLinkEbayHTML() {
        $publiEbay = $this->getPublicacionEbay();
        if ($publiEbay)
            return "<a class='btn btn-primary' href='".$publiEbay->getLinkPublicacion()."' target='_blank'>Link EBAY</a>";
        else
            return "Publi sin proveedor";
    }

        
    public function getUpc() {
       return $this->getValueAttr("UPC");
    }

    public function getMpn() {
        return $this->getValueAttr("MPN");
    }

    public function getEan() {
        return $this->getValueAttr("EAN");
    }
    
    private function getValueAttr($attrId) {
        foreach ($this->getAtributos() as $attr) {
            if ($attr->getIdMl() == $attrId)
                    return $attr->getValueName();
                
        }

        return null;
    }

    public function esPropia() {
        return true;
    }

    public function armarTitulo() {
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

        $sufijo = " - 25 días";
        $texto = substr($texto, 0, 60 - strlen($sufijo));
        
        $this->setTitulo($texto.$sufijo);
    }
}
