<?php

namespace KnpU\Domain\User;

use KnpU\Domain\Common\BaseRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends BaseRepository implements UserProviderInterface
{
    /**
     * Injected via setter injection.
     *
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    protected function getClassName(): string
    {
        return 'KnpU\Domain\User\User';
    }

    protected function getTableName(): string
    {
        return 'user';
    }

    /**
     * @param $username
     *
     * @return User
     */
    public function findUserByUsername($username)
    {
        return $this->findOneBy([
            'username' => $username,
        ]);
    }

    /**
     * @param $email
     *
     * @return User
     */
    public function findUserByEmail($email)
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * A helper for testing things out - finds any user.
     *
     * @throws \Exception
     *
     * @return User
     */
    public function findAny()
    {
        $users = $this->findAllBy([], 1);

        if (empty($users)) {
            throw new \Exception('Could not find any users');
        }

        return \array_shift($users);
    }

    /**
     * Overridden to encode the password.
     *
     * @param $obj
     */
    public function save($obj)
    {
        /** @var User $obj */
        if ($obj->getPlainPassword()) {
            $obj->password = $this->encodePassword($obj, $obj->getPlainPassword());
        }

        parent::save($obj);
    }

    public function loadUserByUsername($username)
    {
        $user = $this->findUserByUsername($username);

        // allow login by email too
        if (!$user) {
            $user = $this->findUserByEmail($username);
        }

        if (!$user) {
            throw new UsernameNotFoundException(\sprintf('Email "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(\sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return $class instanceof User;
    }

    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    private function encodePassword(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        // compute the encoded password for foo
        return $encoder->encodePassword($password, $user->getSalt());
    }
}
