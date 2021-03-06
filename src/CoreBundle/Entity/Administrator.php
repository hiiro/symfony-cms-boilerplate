<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * 管理者
 *
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\AdministratorRepository")
 * @ORM\Table(name="Administrator")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username")
 */
class Administrator  extends BaseUser implements AdvancedUserInterface
{

    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=128)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=128, nullable=true)
     */
    protected $image;

    /**
     * @var string
     * @ORM\Column(name="search_index", type="text", nullable=true)
     */
    private $searchIndex = null;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Administrator
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function onUpdate()
    {
        $this->searchIndex = (string)
            $this->getName() . ' ' .
            $this->getUsernameCanonical() . ' ' .
            $this->getEmailCanonical() . ' '
        ;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Administrator
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set searchIndex
     *
     * @param string $searchIndex
     *
     * @return Administrator
     */
    public function setSearchIndex($searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }

    /**
     * Get searchIndex
     *
     * @return string
     */
    public function getSearchIndex()
    {
        return $this->searchIndex;
    }
}
