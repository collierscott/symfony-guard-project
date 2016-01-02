<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
    
    /**
     * @Route("/secure")
     */
    public function secureAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return new Response('It works!');
    }
    
}
