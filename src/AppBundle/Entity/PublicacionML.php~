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
