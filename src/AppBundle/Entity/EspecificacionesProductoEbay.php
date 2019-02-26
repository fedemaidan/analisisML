<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EspecificacionesProductoEbay
 *
 * @ORM\Table(name="especificaciones_producto_ebay")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EspecificacionesProductoEbayRepository")
 */
class EspecificacionesProductoEbay
{
    const ORM_ENTITY = "AppBundle:EspecificacionesProductoEbay";
    public function __construct() {
        $this->publicacionesEbay = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="PublicacionEbay", mappedBy="especificaciones")
     */
    private $publicacionesEbay;


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
     * Set name
     *
     * @param string $name
     *
     * @return EspecificacionesProductoEbay
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return EspecificacionesProductoEbay
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

     public function __toString()
    {
        return $this->name. ": ". $this->value;
    }

    /**
     * Add publicacionesEbay
     *
     * @param \AppBundle\Entity\PublicacionEbay $publicacionesEbay
     *
     * @return EspecificacionesProductoEbay
     */
    public function addPublicacionesEbay(\AppBundle\Entity\PublicacionEbay $publicacionesEbay)
    {
        $this->publicacionesEbay[] = $publicacionesEbay;

        return $this;
    }

    /**
     * Remove publicacionesEbay
     *
     * @param \AppBundle\Entity\PublicacionEbay $publicacionesEbay
     */
    public function removePublicacionesEbay(\AppBundle\Entity\PublicacionEbay $publicacionesEbay)
    {
        $this->publicacionesEbay->removeElement($publicacionesEbay);
    }

    /**
     * Get publicacionesEbay
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublicacionesEbay()
    {
        return $this->publicacionesEbay;
    }
}
