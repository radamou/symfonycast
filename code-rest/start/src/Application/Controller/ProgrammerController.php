<?php

namespace KnpU\Application\Controller;

use KnpU\CodeBattle\Model\Programmer;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProgrammerController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->get('/programmers/new', [$this, 'newAction'])->bind('programmer_new');
        $controllers->post('/programmers/new', [$this, 'handleNewAction'])->bind('programmer_new_handle');
        $controllers->get('/programmers/choose', [$this, 'chooseAction'])->bind('programmer_choose');
        $controllers->get('/programmers/{nickname}', [$this, 'showAction'])->bind('programmer_show');
        $controllers->post('/programmers/{nickname}/power/up', [$this, 'powerUpAction'])->bind('programmer_powerup');
    }

    /**
     * Create a new programmer.
     */
    public function newAction()
    {
        $programmer = new Programmer();

        return $this->render('programmer/new.twig', ['programmer' => $programmer]);
    }

    /**
     * Create a new programmer.
     */
    public function handleNewAction(Request $request)
    {
        $programmer = new Programmer();

        $errors = [];
        $data = $this->getAndValidateData($request, $errors);
        $programmer->nickname = $data['nickname'];
        $programmer->avatarNumber = $data['avatarNumber'];
        $programmer->tagLine = $data['tagLine'];
        $programmer->userId = $this->getLoggedInUser()->id;

        if ($errors) {
            return $this->render('programmer/new.twig', ['programmer' => $programmer, 'errors' => $errors]);
        }

        $this->getProgrammerRepository()->save($programmer);

        $this->setFlash(\sprintf('%s has been compiled and is ready for battle!', $programmer->nickname));

        return $this->redirect($this->generateUrl('programmer_show', ['nickname' => $programmer->nickname]));
    }

    public function showAction($nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        if (!$programmer) {
            throw new NotFoundHttpException();
        }

        $projects = $this->getProjectRepository()->findRandom(3);

        return $this->render('programmer/show.twig', [
            'programmer' => $programmer,
            'projects' => $projects,
        ]);
    }

    public function chooseAction()
    {
        $programmers = $this->getProgrammerRepository()->findAllForUser($this->getLoggedInUser());

        return $this->render('programmer/choose.twig', ['programmers' => $programmers]);
    }

    public function powerUpAction($nickname)
    {
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);

        if ($programmer->userId != $this->getLoggedInUser()->id) {
            throw new AccessDeniedException();
        }

        $powerupDetails = $this->container['battle.power_manager']->powerUp($programmer);

        $this->setFlash(
            $powerupDetails['message'],
            $powerupDetails['powerChange'] > 0
        );

        return $this->redirect($this->generateUrl('programmer_show', ['nickname' => $programmer->nickname]));
    }

    /**
     * @param array $errors Array that will be filled with errors (I hate
     *                      passing things by reference, but it makes this simple)
     *
     * @return array
     */
    private function getAndValidateData(Request $request, &$errors)
    {
        $nickname = $request->request->get('nickname');
        $avatarNumber = $request->request->get('avatarNumber');
        $tagLine = $request->request->get('tagLine');

        $errors = [];
        if (!$nickname) {
            $errors[] = 'Give your programmer a nickname!';
        }
        if (!$avatarNumber) {
            $errors[] = 'Choose an awesome avatar bro!';
        }

        $existingProgrammer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        if ($existingProgrammer) {
            $errors[] = 'Looks like that programmer already exists - try a different nickname';
        }

        return [
            'nickname' => $nickname,
            'avatarNumber' => $avatarNumber,
            'tagLine' => $tagLine,
        ];
    }
}
