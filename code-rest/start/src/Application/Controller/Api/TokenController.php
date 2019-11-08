<?php

namespace KnpU\Application\Controller\Api;

use KnpU\Application\Controller\BaseController;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class TokenController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/tokens/new', [$this, 'newAction'])->bind('user_tokens_new_process');
    }

    public function newAction(Request $request)
    {
    }
}
