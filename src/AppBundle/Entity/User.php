<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Serializable;

/**
 * @ORM\Table(name="os_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, Serializable
{
    
    public function __construct()
    {
        $this->isActive = true;
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;
    
    /**
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;
    
    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="Use 1 upper case letter, 1 lower case letter, and 1 number"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;
    
    /**
     * @ORM\Column(name="first_name", type="string", length=80, nullable=true)
     */
    private $firstname;
     
     /**
     * @ORM\Column(name="last_name", type="string", length=80, nullable=true)
     */
    private $lastname;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $gender;
    
    /**
     * @ORM\Column(type="string")
     */
    private $locale;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     */
    private $apiToken;
    
    /**
     * @ORM\Column(name="facebookId", type="string", length=25, unique=true, nullable=true)
     */
    private $facebookId;
    
    /**
     * @var string $facebookName
     * 
     * @ORM\Column(name="facebook_name", type="string", length=255, nullable=true)
     */
    private $facebookName;
    
    /**
     * @var string $googleId
     * 
     * @ORM\Column(name="googleId", type="string", length=25, unique=true, nullable=true)
     */
    private $googleId;
    
    /**
     * @ORM\Column(name="google_display_name", type="string", length=255, nullable=true)
     */
    private $googleDisplayName;
    
    /**
     * @var bool
     * 
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();
    
    /**
     * @var \DateTime $createdAt
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime $updatedAt
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var \DateTime $lastLogin
     * 
     * @ORM\Column(type="datetime")
     */
    private $lastLogin;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * 
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Get plain password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    /**
     * Set plain password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->setPassword(null);
        return $this;
    }
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * Set Locale
     * 
     * @param string $locale
     * 
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
    
    /**
     * Get Locale
     * 
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Set Gender
     * 
     * @param string $gender
     * 
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }
    
    /**
     * Get Gender
     * 
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    /**
     * Set token
     *
     * @param string $token
     *
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
    }
    
        
    /**
     * Set Facebook Id
     * @param string id
     */
    public function setFacebookId($id)
    {
        
        $this->facebookId = $id;
    }
    
    /**
     * Get Facebook Id
     * 
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
    
    /**
     * Set Facebook Name
     * @param string name
     */
    public function setFacebookName($name) 
    {
        $this->facebookName = $name;
    }
    
    /**
     * Get Facebook Name
     * 
     * @return string
     */
     public function getFacebookName()
     {
         return $this->facebookName;
     }
    
    /**
     * Set Google Id
     * 
     * @param string id
     */
    public function setGoogleId($id)
    {
        
        $this->googleId = $id;
    }
    
    /**
     * Get Google Id
     * 
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }
    
    /**
     * Set Google Display Name
     * 
     * @param string name
     */
    public function setGoogleDisplayName($name)
    {
        
        $this->googleDisplayName = $name;
        
    }
    
    /**
     * Get Google Display Name
     * 
     * @return string
     */
    public function getGoogleDisplayName()
    {
        return $this->googleDisplayName;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        // allows for chaining
        return $this;
    }
    
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    
    public function __toString()
    {
        return (string) $this->getUsername();
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }
    
    public function isAccountNonLocked()
    {
        return true;
    }
    
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set Last Login
     * 
     * @param \DateTime $login
     */
    public function setLastLogin($login)
    {
        $this->lastLogin = $login;
    }
    
    /**
     * Get Last Login
     * 
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            $this->apiToken
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            $this->apiToken
        ) = unserialize($serialized);
    }
    
}
