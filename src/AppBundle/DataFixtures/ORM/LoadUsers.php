<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\User;

class LoadUsers implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    
    private $container;
    
    public function load(ObjectManager $manager)
    {
        
        $user = new User();
        $user->setUsername('karen');
        //$user->setPassword($this->encodePassword($user, 'karenpass'));
        $user->setPlainPassword('karenpass');
        $user->setApiToken('123abc');
        $user->setLocale('en_US');
        $user->setEmail('karen@onlinespaces.com');
        $user->setLastLogin(new \DateTime());
        $manager->persist($user);
       
        $admin = new User();
        $admin->setUsername('scott');
        //$admin->setPassword($this->encodePassword($admin, 'karenpass'));
        $admin->setPlainPassword('scottpass');
        $admin->setApiToken('DkE3KWIXPt6bnzZl6lcTt682WLhWYnLYjTeNyiZqgPJiHoEkjTtx03ECCnWP');
        $admin->setLocale('en_US');
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('scott@onlinespaces.com');
        $admin->setLastLogin(new \DateTime());
        $manager->persist($admin);
        
        // the queries aren't done until now
        $manager->flush();
        
    }
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
    
    public function getOrder()
    {
        return 10;
    }
    
}