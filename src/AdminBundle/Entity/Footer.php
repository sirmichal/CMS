<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Footer
 *
 * @ORM\Table(name="footer")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\FooterRepository")
 */
class Footer
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
     * @ORM\Column(name="attr", type="string", length=255, nullable=true)
     */
    private $attr;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * Footer constructor.
     * @param string $attr
     * @param string $value
     */
    public function __construct($attr = "", $value = "")
    {
        $this->attr = $attr;
        $this->value = $value;
    }

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
     * Set attr
     *
     * @param string $attr
     *
     * @return Footer
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;

        return $this;
    }

    /**
     * Get attr
     *
     * @return string
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Footer
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
}

