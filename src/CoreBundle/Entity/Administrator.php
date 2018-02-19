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
}
