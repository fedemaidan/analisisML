<?php
/*
    http://www.isoldwhat.com/getcats/index.php
*/
    
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriaEbay
 *
 * @ORM\Table(name="categoria_ebay")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaEbayRepository")
 */
class CategoriaEbay
{
    const ORM_ENTITY = "AppBundle:CategoriaEbay";
    
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
     * @ORM\Column(name="idEbay", type="string", length=255, unique=true)
     */
    private $idEbay;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ratio", type="decimal", precision=10, scale=2)
     */
    private $ratio;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping", type="decimal", precision=10, scale=2)
     */
    private $shipping;

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
     * Set idEbay
     *
     * @param string $idEbay
     *
     * @return CategoriaEbay
     */
    public function setIdEbay($idEbay)
    {
        $this->idEbay = $idEbay;

        return $this;
    }

    /**
     * Get idEbay
     *
     * @return string
     */
    public function getIdEbay()
    {
        return $this->idEbay;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CategoriaEbay
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set ratio
     *
     * @param string $ratio
     *
     * @return CategoriaEbay
     */
    public function setRatio($ratio)
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * Get ratio
     *
     * @return string
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * Set shipping
     *
     * @param string $shipping
     *
     * @return CategoriaEbay
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return string
     */
    public function getShipping()
    {
        return $this->shipping;
    }
}
