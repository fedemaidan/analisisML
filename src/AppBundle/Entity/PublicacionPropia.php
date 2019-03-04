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

    public $notificar_ml = true;

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
}
