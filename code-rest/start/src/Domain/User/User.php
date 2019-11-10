<?php

namespace KnpU\Domain\User;

use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Hateoas\Relation("self", href="expr('/api/users/' ~ object.getId())")
 */
class User implements UserInterface
{
    /* All public properties are persisted */
    public $id;

    public $email;

    public $password;

    public $username;

    /* non-persisted properties */
    private $plainPassword;

    /**
     * Start: Security-related stuff.
     */
    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->password = null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
