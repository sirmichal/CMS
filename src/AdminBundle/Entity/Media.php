<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Media
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="media_upload", fileNameProperty="name")
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Slider", mappedBy="media")
     */
    private $sliders;

    public function __construct()
    {
        $this->sliders = new ArrayCollection();
    }

    /**
     * @param File|UploadedFile $file
     * @return Media
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $name
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}
