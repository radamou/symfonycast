<?php


namespace KnpU\CodeBattle\Controller\Api;


use KnpU\CodeBattle\Controller\BaseController;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class TokenController extends BaseController
{

    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/tokens/new', array($this, 'newAction'))->bind('user_tokens_new_process');
    }

    public function newAction(Request $request)
    {

    }
}
