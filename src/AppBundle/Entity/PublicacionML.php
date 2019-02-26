<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicacionML
 *
 * @ORM\Table(name="publicacion_ml")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicacionMLRepository")
 */
class PublicacionML
{

    use Traits\PublicacionMLTrait;

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
     * @ORM\ManyToMany(targetEntity="AtributoML", inversedBy="publicacionML")
     * @ORM\JoinTable(name="publicaciones_atributos_ml")
     */
    private $atributos;

    public function getAtributos() {
        return $this->atributos;
    }

    public function setAtributos($atributos) {
        return $this->atributos = $atributos;
    }

    public function addAtributo($attr) {
        $this->atributos[] = $attr;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->atributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return PublicacionML
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
     * Set model
     *
     * @param string $model
     *
     * @return PublicacionML
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
     * @return PublicacionML
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
     * @return PublicacionML
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
     * Remove atributo
     *
     * @param \AppBundle\Entity\AtributoML $atributo
     */
    public function removeAtributo(\AppBundle\Entity\AtributoML $atributo)
    {
        $this->atributos->removeElement($atributo);
    }

    /**
     * Set ean
     *
     * @param integer $ean
     *
     * @return PublicacionML
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

}
