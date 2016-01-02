<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        
        $user = new User();
        
        $form = $form = $this->createForm(RegistrationFormType::class, $user);
            
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $data = $form->getData();
            $user->setRoles(array('ROLE_USER'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $guardHandler = $this->container->get('security.authentication.guard_handler');
            
            $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->get('app_form_login_authenticator'),
                'main'
                );
             
            return $this->redirectToRoute('homepage');
             
        }
            
        return array('form' => $form->createView());
        
    }
        
}
