<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Called on every request. Return whatever credentials you want,
     * or null to stop authentication.
     */
    public function getCredentials(Request $request) 
    {
        
        //var_dump($request);
        
        $token = $request->headers->get('X-AUTH-TOKEN');
        
        if (!$token) {
            // no token? Return null and no other methods will be called
            return;
        }

        // What you return here will be passed to getUser() as $credentials
        return array(
            'token' => $token,
        );
        
    }
    
    public function getUser($credentials, UserProviderInterface $userProvider) 
    {
        
        $token = $credentials['token'];
        
        //var_dump($credentials);
        
        $user = $this->container            
            ->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:User')
            ->findOneBy(['apiToken' => $token]);
        
        //var_dump($user);
        
        // if null, authentication will fail
        // if a User object, checkCredentials() is called
        // This allows us to control the message a bit more
        if (!$user) {
            throw new AuthenticationCredentialsNotFoundException();
        }
        
        return $user;
        
    }
    
    public function checkCredentials($credentials, UserInterface $user)
    {
        // return true to cause authentication success
        return true;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, 403);
        
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //Let the request continue to the controller
        return;
    }
    
    public function start(Request $request, AuthenticationException $exception = null) 
    {

        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, 401);
        
    }
    
    public function supportsRememberMe()
    {
        return false;
    }
    
}