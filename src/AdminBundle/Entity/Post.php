<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Media")
     */
    private $thumbnail;

    /**
     * @var Category
     *
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Category", inversedBy="posts")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Post
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set thumbnail
     *
     * @param Media $thumbnail
     *
     * @return Post
     */
    public function setThumbnail(Media $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return Media
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Get categories
     *
     * @return Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories
     * @param ArrayCollection $categories
     * @return $this
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;
        return $this;
    }

}

