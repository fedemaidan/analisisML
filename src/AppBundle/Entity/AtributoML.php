<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AtributoML
 *
 * @ORM\Table(name="atributo_ml")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AtributoMLRepository")
 */
class AtributoML
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
     * @ORM\Column(name="id_ml", type="string", length=255)
     */
    private $idMl;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value_id",  type="string", length=255, nullable=true)
     */
    private $valueId;

    /**
     * @var string
     *
     * @ORM\Column(name="value_name", type="string", length=255, nullable=true)
     */
    private $valueName;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_group_id", type="string", length=255, nullable=true)
     */
    private $attributeGroupId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_group_name", type="string", length=255, nullable=true)
     */
    private $attributeGroupName;


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
     * @return AtributoML
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
     * Set name
     *
     * @param string $name
     *
     * @return AtributoML
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
     * Set valueId
     *
     * @param integer $valueId
     *
     * @return AtributoML
     */
    public function setValueId($valueId)
    {
        $this->valueId = $valueId;

        return $this;
    }

    /**
     * Get valueId
     *
     * @return int
     */
    public function getValueId()
    {
        return $this->valueId;
    }

    /**
     * Set valueName
     *
     * @param string $valueName
     *
     * @return AtributoML
     */
    public function setValueName($valueName)
    {
        $this->valueName = $valueName;

        return $this;
    }

    /**
     * Get valueName
     *
     * @return string
     */
    public function getValueName()
    {
        return $this->valueName;
    }

    /**
     * Set attributeGroupId
     *
     * @param string $attributeGroupId
     *
     * @return AtributoML
     */
    public function setAttributeGroupId($attributeGroupId)
    {
        $this->attributeGroupId = $attributeGroupId;

        return $this;
    }

    /**
     * Get attributeGroupId
     *
     * @return string
     */
    public function getAttributeGroupId()
    {
        return $this->attributeGroupId;
    }

    /**
     * Set attributeGroupName
     *
     * @param string $attributeGroupName
     *
     * @return AtributoML
     */
    public function setAttributeGroupName($attributeGroupName)
    {
        $this->attributeGroupName = $attributeGroupName;

        return $this;
    }

    /**
     * Get attributeGroupName
     *
     * @return string
     */
    public function getAttributeGroupName()
    {
        return $this->attributeGroupName;
    }

    public function __toString()
    {
        return $this->name. ": ". $this->valueName;
    }
}
