<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriaML
 *
 * @ORM\Table(name="categoria_ml")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaMLRepository")
 */
class CategoriaML
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
     * @ORM\Column(name="idMl", type="string", length=255, unique=true)
     */
    private $idMl;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var CategoriaML
     * @ORM\ManyToOne(targetEntity="CategoriaML")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoriaPadre;


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
     * Set idMl
     *
     * @param string $idMl
     *
     * @return CategoriaML
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CategoriaML
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
     * Set categoriaPadre
     *
     * @param \AppBundle\Entity\CategoriaML $categoriaPadre
     *
     * @return CategoriaML
     */
    public function setCategoriaPadre(\AppBundle\Entity\CategoriaML $categoriaPadre = null)
    {
        $this->categoriaPadre = $categoriaPadre;

        return $this;
    }

    /**
     * Get categoriaPadre
     *
     * @return \AppBundle\Entity\CategoriaML
     */
    public function getCategoriaPadre()
    {
        return $this->categoriaPadre;
    }

    public function __toString()
    {
        $padre = '';
        if ($this->getCategoriaPadre())
            $padre = $this->getCategoriaPadre()." - ";
        return $padre.$this->nombre;
    }    
}
