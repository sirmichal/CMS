<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Footer
 *
 * @ORM\Table(name="key_value")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\KeyValueRepository")
 */
class KeyValue
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
     * @ORM\Column(name="form", type="string", length=255)
     */
    private $form;

    /**
     * @var string
     *
     * @ORM\Column(name="attr", type="string", length=255)
     */
    private $attr;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * Footer constructor.
     * @param string $form
     * @param string $attr
     * @param string $value
     */
    public function __construct($form = "", $attr = "", $value = "")
    {
        $this->form = $form;
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
     * @return KeyValue
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
     * @return KeyValue
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

    /**
     * Set form
     *
     * @param string $form
     *
     * @return KeyValue
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }

}

