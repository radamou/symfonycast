<?php

namespace KnpU\Application\Controller\Api;

use KnpU\Application\Controller\BaseController;
use KnpU\Infrastructure\Security\Token\ApiToken;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class TokenController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/tokens', [$this, 'newAction']);
    }

    public function newAction(Request $request)
    {
        $username = $request->headers->get('PHP_AUTH_USER');
        $data = $this->decodeRequestBody($request);
        $user = $this->getUserRepository()->findUserByUsername($username);

        $token = new ApiToken($user->id);
        $token->notes = $data['notes'];

        $this->getApiTokenRepository()->save($token);

        return $this->createApiResponse($token, 201);
    }
}
