<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Media;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\SliderRepository")
 */
class Slider
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
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="sliders")
     */
    private $media;

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
     * Set thumbnail
     *
     * @param Media $media
     *
     * @return Slider
     */
    public function setMedia(Media $media) {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return Media
     */
    public function getMedia() {
        return $this->media;
    }

}

