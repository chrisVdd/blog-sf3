<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping        as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="App\MainBundle\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     * @var UploadedFile
//     */
//    private $file;
//
//    /**
//     * @var string
//     */
//    private $tempFilename;
//
//    /**
//     * @var Post
//     *
//     * @ORM\ManyToOne(targetEntity="App\MainBundle\Entity\Post", inversedBy="images")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $post;
//
//    /**
//     * @var \DateTime $created
//     *
//     * @Gedmo\Timestampable(on="create")
//     * @ORM\Column(type="datetime")
//     */
//    private $created;
//
//    /**
//     * @var \DateTime $updated
//     *
//     * @Gedmo\Timestampable(on="update")
//     * @ORM\Column(type="datetime")
//     */
//    private $updated;
//
//
//    /**
//     * Get id
//     *
//     * @return integer
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Set created
//     *
//     * @param \DateTime $created
//     *
//     * @return Image
//     */
//    public function setCreated($created)
//    {
//        $this->created = $created;
//
//        return $this;
//    }
//
//    /**
//     * Get created
//     *
//     * @return \DateTime
//     */
//    public function getCreated()
//    {
//        return $this->created;
//    }
//
//    /**
//     * Set updated
//     *
//     * @param \DateTime $updated
//     *
//     * @return Image
//     */
//    public function setUpdated($updated)
//    {
//        $this->updated = $updated;
//
//        return $this;
//    }
//
//    /**
//     * Get updated
//     *
//     * @return \DateTime
//     */
//    public function getUpdated()
//    {
//        return $this->updated;
//    }
//
//    /**
//     * Set post
//     *
//     * @param \App\MainBundle\Entity\Post $post
//     *
//     * @return Image
//     */
//    public function setPost(\App\MainBundle\Entity\Post $post)
//    {
//        $this->post = $post;
//
//        return $this;
//    }
}
