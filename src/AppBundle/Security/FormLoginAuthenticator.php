<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FormLoginAuthenticator extends AbstractGuardAuthenticator
{
    
   /**
    * @var \Symfony\Component\Routing\RouterInterface
    */
    private $router;
    private $container;
    
    public function __construct(ContainerInterface $container, RouterInterface $router)
    {
        $this->container = $container;
        $this->router = $router;
    }
    
    /**
     * Get the authentication credentials from the request. If you return null,
     * authentication will be skipped.
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     */
    public function getCredentials(Request $request)
    {
        
        if ($request->getPathInfo() != '/login_check') {
            return;
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
        
        return array(
            'username' => $username,
            'password' => $password
        );
        
    }
    
    /**
     * Return a UserInterface object based on the credentials returned by getCredentials()
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        
        $username = $credentials['username'];
        
        $userRepo = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:User');
            
            $user =  $userRepo->loadUserByUsername($username);

        return $user;
        
    }
    
    /**
     * Throw an AuthenticationException if the credentials returned by
     * getCredentials() are invalid.
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        
        $plainPassword = $credentials['password'];
        
        $encoder = $this->container->get('security.password_encoder');
        
        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            // throw any AuthenticationException
            throw new BadCredentialsException();
        }
        
        // return true to make authentication successful
        return true;
        
    }
        
    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('login_route');
        return new RedirectResponse($url);
        
    }
    
    /**
     * Called when authentication executed and was successful (for example a
     * RedirectResponse to the last page they visited)
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey){
        $url = $this->router->generate('homepage');
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('login_route');
        return new RedirectResponse($url);
    }
    
    /**
     * {@inheritdoc}
     * 
     * Does this method support remember me cookies?
     */
    public function supportsRememberMe()
    {
        return false;
    }
    
    // protected function getDefaultSuccessRedirectUrl()
    // {
    //     return $this->router->generate('homepage');
    // }
    
    // protected function getLoginUrl()
    // {
    //     return $this->router->generate('login_route');
    // }
    
}