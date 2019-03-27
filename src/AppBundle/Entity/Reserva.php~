<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reserva
 *
 * @ORM\Table(name="reserva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
 */
class Reserva
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
     * @var string
     *
     * @ORM\Column(name="id_ml", type="string", length=255, nullable=true)
     */
    private $idMl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAlta", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $fechaModificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="precioVenta", type="decimal",  precision=9, scale=2)
     */
    private $precioVenta;

    /**
     * @var TipoDePago
     * @ORM\ManyToOne(targetEntity="TipoDePago")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tipoDePago_1;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_pago_1", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $valorPago1;

    /**
     * @var TipoDePago
     * @ORM\ManyToOne(targetEntity="TipoDePago")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tipoDePago_2;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_pago_2", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $valorPago2;

    /**
     * @var string
     *
     * @ORM\Column(name="informacion", type="string", length=2000, nullable=true)
     */
    private $informacion;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1000, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="nick_cliente", type="string", length=1000, nullable=true)
     */
    private $nickCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_cliente", type="string", length=255, nullable=true)
     */
    private $mailCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_cliente", type="string", length=255, nullable=true)
     */
    private $nombreCliente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEstimada", type="datetime", nullable=true)
     */
    private $fechaEstimada;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_documento_cliente", type="string", length=255, nullable=true)
     */
    private $tipoDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_documento_cliente", type="string", length=255, nullable=true)
     */
    private $numeroDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_cliente", type="string", length=255, nullable=true)
     */
    private $apellidoCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_cliente", type="string", length=255, nullable=true)
     */
    private $facebookCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_cliente", type="string", length=255, nullable=true)
     */
    private $telefonoCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_recibe_entrega", type="string", length=255, nullable=true)
     */
    private $nombreRecibeEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="celular_recibe_entrega", type="string", length=255, nullable=true)
     */
    private $celularRecibeEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=true)
     */
    private $fechaEntrega;     

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_entrega", type="string", length=255, nullable=true)
     */
    private $observacionesEntrega;    

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", length=255, nullable=true)
     * @Assert\Choice({"PESOS", "DOLARES"})
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking", type="string", length=255, nullable=true)
     */
    private $tracking;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_reserva", type="string", length=255, nullable=true)
     */
    private $codigoReserva;

    /**
     * @var TipoDePago
     * @ORM\ManyToOne(targetEntity="TipoDePago")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tipoDePago_3;

    /**
     * @var TipoDePago
     * @ORM\ManyToOne(targetEntity="TipoDePago")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tipoDePago_4;

    /**
     * @var Estado
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(nullable=true)
     */
    private $estado;

    /**
     * @var Cuenta
     * @ORM\ManyToOne(targetEntity="Cuenta")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cuenta;

    /**
     * @var Producto
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumn(nullable=true)
     */
    private $producto;

    /**
     * @var string
     *
     * @ORM\Column(name="datos_cliente", type="string", length=1000, nullable=true)
     */
    private $datosCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_pago_3", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $valorPago3;


    /**
     * @var string
     *
     * @ORM\Column(name="valor_pago_4", type="decimal",  precision=7, scale=2, nullable=true)
     */
    private $valorPago4;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago_1", type="datetime", nullable=true)
     */
    private $fechaPago1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago_2", type="datetime", nullable=true)
     */
    private $fechaPago2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago_3", type="datetime", nullable=true)
     */
    private $fechaPago3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago_4", type="datetime", nullable=true)
     */
    private $fechaPago4;

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
     * Set idMl
     *
     * @param string $idMl
     *
     * @return Reserva
     */
    public function setIdMl($idMl)
    {
        $this->idMl = $idMl;

        return $this;
    }

    /**
     * Get idMl
     *
     * @return string
     */
    public function getIdMl()
    {
        return $this->idMl;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Reserva
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Reserva
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set precioVenta
     *
     * @param string $precioVenta
     *
     * @return Reserva
     */
    public function setPrecioVenta($precioVenta)
    {
        $this->precioVenta = $precioVenta;

        return $this;
    }

    /**
     * Get precioVenta
     *
     * @return string
     */
    public function getPrecioVenta()
    {
        return $this->precioVenta;
    }

    /**
     * Set valorPago1
     *
     * @param string $valorPago1
     *
     * @return Reserva
     */
    public function setValorPago1($valorPago1)
    {
        $this->valorPago1 = $valorPago1;

        return $this;
    }

    /**
     * Get valorPago1
     *
     * @return string
     */
    public function getValorPago1()
    {
        return $this->valorPago1;
    }

    /**
     * Set valorPago2
     *
     * @param string $valorPago2
     *
     * @return Reserva
     */
    public function setValorPago2($valorPago2)
    {
        $this->valorPago2 = $valorPago2;

        return $this;
    }

    /**
     * Get valorPago2
     *
     * @return string
     */
    public function getValorPago2()
    {
        return $this->valorPago2;
    }

    /**
     * Set informacion
     *
     * @param string $informacion
     *
     * @return Reserva
     */
    public function setInformacion($informacion)
    {
        $this->informacion = $informacion;

        return $this;
    }

    /**
     * Get informacion
     *
     * @return string
     */
    public function getInformacion()
    {
        return $this->informacion;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Reserva
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set nickCliente
     *
     * @param string $nickCliente
     *
     * @return Reserva
     */
    public function setNickCliente($nickCliente)
    {
        $this->nickCliente = $nickCliente;

        return $this;
    }

    /**
     * Get nickCliente
     *
     * @return string
     */
    public function getNickCliente()
    {
        return $this->nickCliente;
    }

    /**
     * Set mailCliente
     *
     * @param string $mailCliente
     *
     * @return Reserva
     */
    public function setMailCliente($mailCliente)
    {
        $this->mailCliente = $mailCliente;

        return $this;
    }

    /**
     * Get mailCliente
     *
     * @return string
     */
    public function getMailCliente()
    {
        return $this->mailCliente;
    }

    /**
     * Set nombreCliente
     *
     * @param string $nombreCliente
     *
     * @return Reserva
     */
    public function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    /**
     * Get nombreCliente
     *
     * @return string
     */
    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }

    /**
     * Set fechaEstimada
     *
     * @param \DateTime $fechaEstimada
     *
     * @return Reserva
     */
    public function setFechaEstimada($fechaEstimada)
    {
        $this->fechaEstimada = $fechaEstimada;

        return $this;
    }

    /**
     * Get fechaEstimada
     *
     * @return \DateTime
     */
    public function getFechaEstimada()
    {
        return $this->fechaEstimada;
    }

    /**
     * Set tipoDocumento
     *
     * @param string $tipoDocumento
     *
     * @return Reserva
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    /**
     * Get tipoDocumento
     *
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     * Set numeroDocumento
     *
     * @param string $numeroDocumento
     *
     * @return Reserva
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Get numeroDocumento
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Set apellidoCliente
     *
     * @param string $apellidoCliente
     *
     * @return Reserva
     */
    public function setApellidoCliente($apellidoCliente)
    {
        $this->apellidoCliente = $apellidoCliente;

        return $this;
    }

    /**
     * Get apellidoCliente
     *
     * @return string
     */
    public function getApellidoCliente()
    {
        return $this->apellidoCliente;
    }

    /**
     * Set facebookCliente
     *
     * @param string $facebookCliente
     *
     * @return Reserva
     */
    public function setFacebookCliente($facebookCliente)
    {
        $this->facebookCliente = $facebookCliente;

        return $this;
    }

    /**
     * Get facebookCliente
     *
     * @return string
     */
    public function getFacebookCliente()
    {
        return $this->facebookCliente;
    }

    /**
     * Set telefonoCliente
     *
     * @param string $telefonoCliente
     *
     * @return Reserva
     */
    public function setTelefonoCliente($telefonoCliente)
    {
        $this->telefonoCliente = $telefonoCliente;

        return $this;
    }

    /**
     * Get telefonoCliente
     *
     * @return string
     */
    public function getTelefonoCliente()
    {
        return $this->telefonoCliente;
    }

    /**
     * Set nombreRecibeEntrega
     *
     * @param string $nombreRecibeEntrega
     *
     * @return Reserva
     */
    public function setNombreRecibeEntrega($nombreRecibeEntrega)
    {
        $this->nombreRecibeEntrega = $nombreRecibeEntrega;

        return $this;
    }

    /**
     * Get nombreRecibeEntrega
     *
     * @return string
     */
    public function getNombreRecibeEntrega()
    {
        return $this->nombreRecibeEntrega;
    }

    /**
     * Set celularRecibeEntrega
     *
     * @param string $celularRecibeEntrega
     *
     * @return Reserva
     */
    public function setCelularRecibeEntrega($celularRecibeEntrega)
    {
        $this->celularRecibeEntrega = $celularRecibeEntrega;

        return $this;
    }

    /**
     * Get celularRecibeEntrega
     *
     * @return string
     */
    public function getCelularRecibeEntrega()
    {
        return $this->celularRecibeEntrega;
    }

    /**
     * Set fechaEntrega
     *
     * @param \DateTime $fechaEntrega
     *
     * @return Reserva
     */
    public function setFechaEntrega($fechaEntrega)
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    /**
     * Get fechaEntrega
     *
     * @return \DateTime
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * Set observacionesEntrega
     *
     * @param string $observacionesEntrega
     *
     * @return Reserva
     */
    public function setObservacionesEntrega($observacionesEntrega)
    {
        $this->observacionesEntrega = $observacionesEntrega;

        return $this;
    }

    /**
     * Get observacionesEntrega
     *
     * @return string
     */
    public function getObservacionesEntrega()
    {
        return $this->observacionesEntrega;
    }

    /**
     * Set moneda
     *
     * @param string $moneda
     *
     * @return Reserva
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set tracking
     *
     * @param string $tracking
     *
     * @return Reserva
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;

        return $this;
    }

    /**
     * Get tracking
     *
     * @return string
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * Set codigoReserva
     *
     * @param string $codigoReserva
     *
     * @return Reserva
     */
    public function setCodigoReserva($codigoReserva)
    {
        $this->codigoReserva = $codigoReserva;

        return $this;
    }

    /**
     * Get codigoReserva
     *
     * @return string
     */
    public function getCodigoReserva()
    {
        return $this->codigoReserva;
    }

    /**
     * Set datosCliente
     *
     * @param string $datosCliente
     *
     * @return Reserva
     */
    public function setDatosCliente($datosCliente)
    {
        $this->datosCliente = $datosCliente;

        return $this;
    }

    /**
     * Get datosCliente
     *
     * @return string
     */
    public function getDatosCliente()
    {
        return $this->datosCliente;
    }

    /**
     * Set valorPago3
     *
     * @param string $valorPago3
     *
     * @return Reserva
     */
    public function setValorPago3($valorPago3)
    {
        $this->valorPago3 = $valorPago3;

        return $this;
    }

    /**
     * Get valorPago3
     *
     * @return string
     */
    public function getValorPago3()
    {
        return $this->valorPago3;
    }

    /**
     * Set valorPago4
     *
     * @param string $valorPago4
     *
     * @return Reserva
     */
    public function setValorPago4($valorPago4)
    {
        $this->valorPago4 = $valorPago4;

        return $this;
    }

    /**
     * Get valorPago4
     *
     * @return string
     */
    public function getValorPago4()
    {
        return $this->valorPago4;
    }

    /**
     * Set fechaPago1
     *
     * @param \DateTime $fechaPago1
     *
     * @return Reserva
     */
    public function setFechaPago1($fechaPago1)
    {
        $this->fechaPago1 = $fechaPago1;

        return $this;
    }

    /**
     * Get fechaPago1
     *
     * @return \DateTime
     */
    public function getFechaPago1()
    {
        return $this->fechaPago1;
    }

    /**
     * Set fechaPago2
     *
     * @param \DateTime $fechaPago2
     *
     * @return Reserva
     */
    public function setFechaPago2($fechaPago2)
    {
        $this->fechaPago2 = $fechaPago2;

        return $this;
    }

    /**
     * Get fechaPago2
     *
     * @return \DateTime
     */
    public function getFechaPago2()
    {
        return $this->fechaPago2;
    }

    /**
     * Set fechaPago3
     *
     * @param \DateTime $fechaPago3
     *
     * @return Reserva
     */
    public function setFechaPago3($fechaPago3)
    {
        $this->fechaPago3 = $fechaPago3;

        return $this;
    }

    /**
     * Get fechaPago3
     *
     * @return \DateTime
     */
    public function getFechaPago3()
    {
        return $this->fechaPago3;
    }

    /**
     * Set fechaPago4
     *
     * @param \DateTime $fechaPago4
     *
     * @return Reserva
     */
    public function setFechaPago4($fechaPago4)
    {
        $this->fechaPago4 = $fechaPago4;

        return $this;
    }

    /**
     * Get fechaPago4
     *
     * @return \DateTime
     */
    public function getFechaPago4()
    {
        return $this->fechaPago4;
    }

    /**
     * Set tipoDePago1
     *
     * @param \AppBundle\Entity\TipoDePago $tipoDePago1
     *
     * @return Reserva
     */
    public function setTipoDePago1(\AppBundle\Entity\TipoDePago $tipoDePago1 = null)
    {
        $this->tipoDePago_1 = $tipoDePago1;

        return $this;
    }

    /**
     * Get tipoDePago1
     *
     * @return \AppBundle\Entity\TipoDePago
     */
    public function getTipoDePago1()
    {
        return $this->tipoDePago_1;
    }

    /**
     * Set tipoDePago2
     *
     * @param \AppBundle\Entity\TipoDePago $tipoDePago2
     *
     * @return Reserva
     */
    public function setTipoDePago2(\AppBundle\Entity\TipoDePago $tipoDePago2 = null)
    {
        $this->tipoDePago_2 = $tipoDePago2;

        return $this;
    }

    /**
     * Get tipoDePago2
     *
     * @return \AppBundle\Entity\TipoDePago
     */
    public function getTipoDePago2()
    {
        return $this->tipoDePago_2;
    }

    /**
     * Set tipoDePago3
     *
     * @param \AppBundle\Entity\TipoDePago $tipoDePago3
     *
     * @return Reserva
     */
    public function setTipoDePago3(\AppBundle\Entity\TipoDePago $tipoDePago3 = null)
    {
        $this->tipoDePago_3 = $tipoDePago3;

        return $this;
    }

    /**
     * Get tipoDePago3
     *
     * @return \AppBundle\Entity\TipoDePago
     */
    public function getTipoDePago3()
    {
        return $this->tipoDePago_3;
    }

    /**
     * Set tipoDePago4
     *
     * @param \AppBundle\Entity\TipoDePago $tipoDePago4
     *
     * @return Reserva
     */
    public function setTipoDePago4(\AppBundle\Entity\TipoDePago $tipoDePago4 = null)
    {
        $this->tipoDePago_4 = $tipoDePago4;

        return $this;
    }

    /**
     * Get tipoDePago4
     *
     * @return \AppBundle\Entity\TipoDePago
     */
    public function getTipoDePago4()
    {
        return $this->tipoDePago_4;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\Estado $estado
     *
     * @return Reserva
     */
    public function setEstado(\AppBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Reserva
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
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Reserva
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }
}
