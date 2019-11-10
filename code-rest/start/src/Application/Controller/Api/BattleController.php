<?php

namespace KnpU\Application\Controller\Api;

use KnpU\Application\Controller\BaseController;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class BattleController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/battles', [$this, 'newAction']);
        $controllers->get('/api/battles/{id}', [$this, 'showAction'])
            ->bind('api_battle_show');
    }

    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();
        $data = $this->decodeRequestBody($request);
        $programmerId = $data->get('programmerId');
        $projectId = $data->get('projectId');

        $project = $this->getProjectRepository()->find($projectId);
        $programmer = $this->getProgrammerRepository()->find($programmerId);
        $battle = $this->getBattleManager()->battle($programmer, $project);

        $response = $this->createApiResponse($battle, 201);
        $url = $this->generateUrl('api_battle_show', ['id' => $battle->id]);
        $response->headers->set('Location', $url);

        return $response;
    }

    public function showAction($id)
    {
        $battle = $this->getBattleRepository()->find($id);

        if (!$battle) {
            $this->throw404('No battle with id '.$id);
        }

        $response = $this->createApiResponse($battle, 200);

        return $response;
    }
}
