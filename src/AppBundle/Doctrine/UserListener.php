<?php

namespace AppBundle\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use AppBundle\Entity\User;

class UserListener
{
    
    private $encoderFactory;
    
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }
	
	public function prePersist(LifecycleEventArgs $args)
    {    
        $entity = $args->getEntity();
	    if ($entity instanceof User) {
	        $this->handleEvent($entity);
	    }
    }
    
    public function preUpdate(LifecycleEventArgs $args)
	{

	    $entity = $args->getEntity();
		
	    if ($entity instanceof User) {
	        $this->handleEvent($entity);
	    }
	    
	}
   
    private function handleEvent(User $user)
	{

		if (!$user->getPlainPassword()) {
	        return;
	    }
    
	    $plainPassword = $user->getPlainPassword();

	    $encoder = $this->encoderFactory->getEncoder($user);
	    $password = $encoder->encodePassword($plainPassword, $user->getSalt());

	    $user->setPassword($password);
	    
	    //Make sure that a user has at least the role of ROLE_USER when created
	    $roles = $user->getRoles();
	    $user->setRoles($roles);
	    
	    //Make sure that a user has at least the role of ROLE_USER when created
	    $roles = $user->getRoles();
	    $user->setRoles($roles);
	    
	}
    
}
