<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDePago
 *
 * @ORM\Table(name="tipo_de_pago")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoDePagoRepository")
 */
class TipoDePago
{

    const ORM_ENTITY = "AppBundle:TipoDePago";
    const EFECTIVO = "EFECTIVO";
    const MP_USADOS = "MP_USADOS";
    const MP_NUEVOS = "MP_NUEVOS";
    
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="comision", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $comision;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, unique=true)
     */
    private $codigo;


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
     * @return TipoDePago
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return TipoDePago
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

    public function __toString() {
        if (!is_string($this->getNombre()))
            return "" ;
        else
            return $this->getNombre();
    }

    /**
     * Set comision
     *
     * @param string $comision
     *
     * @return TipoDePago
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }
}
