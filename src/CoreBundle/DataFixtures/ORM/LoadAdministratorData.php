<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use CoreBundle\Entity\Administrator;

class LoadAdministratorData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface, ORMFixtureInterface
{

    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $admin = new Administrator();
        $admin->setUsername('admin');
        $admin->setUsernameCanonical('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('administrator@example.com');
        $admin->setEmailCanonical('administrator@example.com');
        $admin->setName('テスト管理者');
        $admin->setEnabled(true);
        $admin->setRoles([]);

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($admin, $admin->getPlainPassword());
        $admin->setPassword($encoded);

        $manager->persist($admin);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}