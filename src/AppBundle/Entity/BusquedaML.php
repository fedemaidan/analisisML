<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BusquedaML
 *
 * @ORM\Table(name="busqueda_ml")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BusquedaMLRepository")
 */
class BusquedaML
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="precioMaximo", type="integer", nullable=true)
     */
    private $precioMaximo;

    /**
     * @var int
     *
     * @ORM\Column(name="precioMinimo", type="integer", nullable=true)
     */
    private $precioMinimo;

    /**
     * @var CategoriaML
     * @ORM\ManyToOne(targetEntity="CategoriaML")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaML;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_actual", type="string", length=255, nullable=true)
     */
    private $estado_actual;   

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
     * Set precioMaximo
     *
     * @param integer $precioMaximo
     *
     * @return BusquedaML
     */
    public function setPrecioMaximo($precioMaximo)
    {
        $this->precioMaximo = $precioMaximo;

        return $this;
    }

    /**
     * Get precioMaximo
     *
     * @return int
     */
    public function getPrecioMaximo()
    {
        return $this->precioMaximo;
    }

    /**
     * Set precioMinimo
     *
     * @param integer $precioMinimo
     *
     * @return BusquedaML
     */
    public function setPrecioMinimo($precioMinimo)
    {
        $this->precioMinimo = $precioMinimo;

        return $this;
    }

    /**
     * Get precioMinimo
     *
     * @return int
     */
    public function getPrecioMinimo()
    {
        return $this->precioMinimo;
    }

    /**
     * Set categoriaML
     *
     * @param \AppBundle\Entity\CategoriaML $categoriaML
     *
     * @return BusquedaML
     */
    public function setCategoriaML(\AppBundle\Entity\CategoriaML $categoriaML = null)
    {
        $this->categoriaML = $categoriaML;

        return $this;
    }

    /**
     * Get categoriaML
     *
     * @return \AppBundle\Entity\CategoriaML
     */
    public function getCategoriaML()
    {
        return $this->categoriaML;
    }

    /**
     * Set estadoActual
     *
     * @param string $estadoActual
     *
     * @return BusquedaML
     */
    public function setEstadoActual($estadoActual)
    {
        $this->estado_actual = $estadoActual;

        return $this;
    }

    /**
     * Get estadoActual
     *
     * @return string
     */
    public function getEstadoActual()
    {
        return $this->estado_actual;
    }
}
