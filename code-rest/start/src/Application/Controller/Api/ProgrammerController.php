<?php

namespace KnpU\Application\Controller\Api;

use KnpU\CodeBattle\Api\ApiProblem;
use KnpU\CodeBattle\Api\ApiProblemException;
use KnpU\Application\Controller\BaseController;
use KnpU\CodeBattle\Model\Programmer;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgrammerController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/programmers', [$this, 'newAction']);
        $controllers->get('/api/programmers/{nickname}', [$this, 'showAction'])
            ->bind('api_programmers_show');
        $controllers->get('/api/programmers', [$this, 'listAction']);
        $controllers->put('/api/programmers/{nickname}', [$this, 'updateAction']);
        $controllers->delete('/api/programmers/{nickname}', [$this, 'deleteAction']);
    }

    public function showAction($nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);

        if (!$programmer) {
            $this->throw404('Crap! This programmer has deserted! We\'ll send a search party');
        }

        $response = $this->createApiResponse($programmer);

        return $response;
    }

    public function listAction()
    {
        $programmers = $this->getProgrammerRepository()->findAll();

        return $this->createApiResponse(['programmers' => $programmers]);
    }

    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();
        $programmer = new Programmer();
        $this->handleRequest($request, $programmer);
        $errors = $this->validate($programmer);

        if (!empty($errors)) {
            $this->throwApiProblemValidationException($errors);
        }

        $this->save($programmer);

        $programmerUrl = $this->generateUrl('api_programmers_show', ['nickname' => $programmer->nickname]);
        $response = $this->createApiResponse($programmer, 201);
        $response->headers->set('Location', $programmerUrl);

        return $response;
    }

    public function updateAction($nickname, Request $request)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);

        $this->enforceProgrammerOwnershipSecurity($programmer);

        if (!$programmer) {
            $this->throw404();
        }

        $errors = $this->validate($programmer);

        if (!empty($errors)) {
            $this->throwApiProblemValidationException($errors);
        }

        $this->handleRequest($request, $programmer);
        $this->save($programmer);

        return $this->createApiResponse($programmer);
    }

    public function deleteAction($nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        $this->enforceProgrammerOwnershipSecurity($programmer);

        if ($programmer) {
            $this->delete($programmer);
        }

        return new Response(null, 204);
    }

    private function handleRequest(Request $request, Programmer $programmer)
    {
        $data = \json_decode($request->getContent(), true);

        if (null === $data) {
            $problem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);

            throw new ApiProblemException($problem);
        }

        // determine which properties should be changeable on this request
        $apiProperties = ['avatarNumber', 'tagLine'];

        if (!$programmer->id) {
            $apiProperties[] = 'nickname';
        }

        // update the properties
        foreach ($apiProperties as $property) {
            $programmer->$property = $data[$property] ?? null;
        }

        $programmer->userId = $this->getLoggedInUser()->id;
    }

    //https://tools.ietf.org/html/draft-nottingham-http-problem-07
    private function throwApiProblemValidationException(array $errors)
    {
        $apiProblem = new ApiProblem(400, ApiProblem::TYPE_VALIDATION_ERROR);
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }
}
