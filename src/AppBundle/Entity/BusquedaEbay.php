<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BusquedaEbay
 *
 * @ORM\Table(name="busqueda_ebay")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BusquedaEbayRepository")
 */
class BusquedaEbay
{
    const ORM_ENTITY = "AppBundle:BusquedaEbay";
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
     * @ORM\Column(name="vendedor_ebay_id", type="string", length=255)
     */
    private $vendedorEbayId;


    /**
     * @var bool
     *
     * @ORM\Column(name="filtrar_new", type="boolean", nullable=true)
     */
    private $filtrarNew;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_minimo", type="string", length=255, nullable=true)
     */
    private $precioMinimo;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_maximo", type="string", length=255, nullable=true)
     */
    private $precioMaximo;

    /**
     * @var categoriaEbay
     * @ORM\ManyToOne(targetEntity="CategoriaEbay")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaEbay;

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
     * Set vendedorEbayId
     *
     * @param string $vendedorEbayId
     *
     * @return BusquedaEbay
     */
    public function setVendedorEbayId($vendedorEbayId)
    {
        $this->vendedorEbayId = $vendedorEbayId;

        return $this;
    }

    /**
     * Get vendedorEbayId
     *
     * @return string
     */
    public function getVendedorEbayId()
    {
        return $this->vendedorEbayId;
    }

    /**
     * Set filtrarNew
     *
     * @param boolean $filtrarNew
     *
     * @return BusquedaEbay
     */
    public function setFiltrarNew($filtrarNew)
    {
        $this->filtrarNew = $filtrarNew;

        return $this;
    }

    /**
     * Get filtrarNew
     *
     * @return bool
     */
    public function getFiltrarNew()
    {
        return $this->filtrarNew;
    }

    /**
     * Set precioMinimo
     *
     * @param string $precioMinimo
     *
     * @return BusquedaEbay
     */
    public function setPrecioMinimo($precioMinimo)
    {
        $this->precioMinimo = $precioMinimo;

        return $this;
    }

    /**
     * Get precioMinimo
     *
     * @return string
     */
    public function getPrecioMinimo()
    {
        return $this->precioMinimo;
    }

    /**
     * Set precioMaximo
     *
     * @param string $precioMaximo
     *
     * @return BusquedaEbay
     */
    public function setPrecioMaximo($precioMaximo)
    {
        $this->precioMaximo = $precioMaximo;

        return $this;
    }

    /**
     * Get precioMaximo
     *
     * @return string
     */
    public function getPrecioMaximo()
    {
        return $this->precioMaximo;
    }


    /**
     * Set categoriaEbay
     *
     * @param \AppBundle\Entity\CategoriaEbay $categoriaEbay
     *
     * @return BusquedaEbay
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

    public function __toString()
    {
        return $this->vendedorEbayId != null ? $this->vendedorEbayId : "";
    }


    /**
     * Set estadoActual
     *
     * @param string $estadoActual
     *
     * @return BusquedaEbay
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
