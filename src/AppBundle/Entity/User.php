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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;
    
    /**
     * @ORM\Column(name="password", type="string", length=255)
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

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
        $this->setPlainPassword(null);
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
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ) = unserialize($serialized);
    }
    
}
