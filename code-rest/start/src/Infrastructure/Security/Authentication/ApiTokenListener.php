<?php

namespace KnpU\Infrastructure\Security\Authentication;

use KnpU\Infrastructure\Security\Authentication\Exception\BadAuthHeaderFormatException;
use KnpU\Infrastructure\Security\Authentication\Exception\BadAuthHeaderTypeException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Responsible for reading the token string off of the Authorization header.
 */
class ApiTokenListener implements ListenerInterface
{
    const AUTHORIZATION_HEADER_TOKEN_KEY = 'token';

    private $securityContext;
    private $authenticationManager;

    public function __construct(
        SecurityContextInterface $securityContext,
        AuthenticationManagerInterface $authenticationManager)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        // there may not be authentication information on this request
        if (!$request->headers->has('Authorization')) {
            return;
        }

        $authorisation = $this->parseAuthorizationHeader(
            $request->headers->get('Authorization')
        );
        if (!$authorisation) {
            // there's no authentication info for us to process
            return;
        }

        // create an object that just exists to hold onto the token string for us
        $token = new ApiAuthToken();
        $token->setAuthToken($authorisation);

        $returnValue = $this->authenticationManager->authenticate($token);

        if ($returnValue instanceof TokenInterface) {
            return $this->securityContext->setToken($returnValue);
        }
    }

    /**
     * Parses the Authorization header and returns only the token.
     *
     * Authorization Header: "token ABCDEFG"
     *
     * will return "ABCDEFG"
     *
     * @param $authorizationHeader
     *
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationException
     *
     * @return string
     */
    private function parseAuthorizationHeader($authorizationHeader)
    {
        $pieces = \explode(' ', $authorizationHeader);

        // if the format of the authorization header looks wrong
        if (2 != \count($pieces)) {
            // authentication exception with a special message
            throw new BadAuthHeaderFormatException();
        }

        // allow the 'Basic' auth type still - just don't handle it here
        if ('Basic' == $pieces[0]) {
            return;
        }

        // if the format is not "token AUTH_TOKEN"
        if (self::AUTHORIZATION_HEADER_TOKEN_KEY != $pieces[0]) {
            // authentication exception with a special message
            throw new BadAuthHeaderTypeException();
        }

        return $pieces[1];
    }
}
