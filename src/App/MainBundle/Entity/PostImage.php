<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 4/11/17
 * Time: 11:41
 */

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping                    as ORM;
use Vich\UploaderBundle\Mapping\Annotation  as Vich;
use Gedmo\Mapping\Annotation                as Gedmo;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class PostImage
 *
 * @ORM\Table(name="post_image")
 * @ORM\Entity(repositoryClass="App\MainBundle\Repository\PostImageRepository")
 * @Vich\Uploadable
 */
class PostImage
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
     * @ORM\ManyToOne(targetEntity="App\MainBundle\Entity\Post", inversedBy="images")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @var File
     * @Vich\UploadableField(mapping="post_image", fileNameProperty="imageName", size="imageSize")
     *
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $imageSize;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get ImageFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return $this
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updated = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Set ImageFile
     *
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return PostImage
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return PostImage
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer|null
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set post
     *
     * @param \App\MainBundle\Entity\Post $post
     *
     * @return PostImage
     */
    public function setPost(\App\MainBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \App\MainBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PostImage
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
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return PostImage
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
