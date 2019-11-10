<?php

namespace KnpU\Application\Controller\Api;

use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use KnpU\Application\Controller\BaseController;
use KnpU\Domain\Home\Homepage;
use KnpU\Domain\Programmer\Programmer;
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
        $controllers->get('/api/programmers', [$this, 'listAction'])->bind('api_programmers_list');
        $controllers->put('/api/programmers/{nickname}', [$this, 'updateAction']);
        $controllers->delete('/api/programmers/{nickname}', [$this, 'deleteAction']);
        $controllers->get('/api/programmers/{nickname}/battles', [$this, 'listBattlesAction'])
            ->bind('api_programmers_battles_list');
        $controllers->get('/api', [$this, 'homepageAction'])->bind('api_homepage');
    }

    public function homepageAction()
    {
        $homepage = new Homepage();

        return $this->createApiResponse($homepage);
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

    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $limit;

        $nicknameFilter = $request->query->get('nickname');

        if ($nicknameFilter) {
            $programmers = $this->getProgrammerRepository()
                ->findAllLike(['nickname' => '%'.$nicknameFilter.'%']);
        } else {
            $programmers = $this->getProgrammerRepository()->findAll();
        }

        $collection = new CollectionRepresentation(\array_slice($programmers, $offset, $limit));
        $numberOfPages = (int) \ceil(\count($programmers) / $limit);

        $paginated = new PaginatedRepresentation(
            $collection,
            'api_programmers_list',
            [],
            $page,
            $limit,
            $numberOfPages
        );

        return $this->createApiResponse($paginated, 200, 'json');
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

    public function updateAction(string $nickname, Request $request)
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

    public function deleteAction(string $nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        $this->enforceProgrammerOwnershipSecurity($programmer);

        if ($programmer) {
            $this->delete($programmer);
        }

        return new Response(null, 204);
    }

    public function listBattlesAction(string $nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);

        if (!$programmer) {
            $this->throw404('Oh no! This programmer has deserted! We\'ll send a search party!');
        }

        $battles = $this->getBattleRepository()
            ->findAllBy(['programmerId' => $programmer->id]);

        $collection = new CollectionRepresentation($battles);
        $response = $this->createApiResponse($collection);

        return $response;
    }

    private function handleRequest(Request $request, Programmer $programmer)
    {
        $data = $this->decodeRequestBody($request);

        // determine which properties should be changeable on this request
        $apiProperties = ['avatarNumber', 'tagLine'];

        if (!$programmer->id) {
            $apiProperties[] = 'nickname';
        }

        // update the properties
        foreach ($apiProperties as $property) {
            if (!$data->has($property) && $request->isMethod('PATCH')) {
                continue;
            }

            $programmer->$property = $data->get($property);
        }

        $programmer->userId = $this->getLoggedInUser()->id;
    }
}
