<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GoogleController extends Controller
{
    
    /**
     * @Route("/connect/google", name="connect_google")
     */
    public function connectGoogleAction(Request $request)
    {
        return $this->get('app_google_authenticator')->start($request);
    }
    
    /**
     * @Route("/connect/google-check", name="connect_google_check")
     */
    public function secureAction()
    {
        // will not be reached!
    }
    
    
}