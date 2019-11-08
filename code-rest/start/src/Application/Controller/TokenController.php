<?php

namespace KnpU\Application\Controller;

use KnpU\CodeBattle\Security\Token\ApiToken;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TokenController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->get('/tokens', [$this, 'indexAction'])->bind('user_tokens');
        $controllers->get('/tokens/new', [$this, 'newAction'])->bind('user_tokens_new');
        $controllers->post('/tokens/new', [$this, 'newAction'])->bind('user_tokens_new_process');
        $controllers->post('/tokens/{token}/delete', [$this, 'deleteAction'])->bind('user_tokens_delete');
    }

    /**
     * Displays all of the user's tokens.
     */
    public function indexAction()
    {
        $tokens = $this->getApiTokenRepository()->findAllForUser($this->getLoggedInUser());

        return $this->render('tokens/index.twig', [
            'tokens' => $tokens,
        ]);
    }

    public function newAction(Request $request)
    {
        $token = new ApiToken($this->getLoggedInUser()->id);
        $errors = [];
        if ($request->isMethod('POST')) {
            $token->notes = $request->request->get('notes');

            $errors = $this->validate($token);
            if (empty($errors)) {
                $this->getApiTokenRepository()->save($token);

                $this->setFlash('Yeehaw! You just created an API token');
                $url = $this->generateUrl('user_tokens');

                return $this->redirect($url);
            }
        }

        return $this->render('tokens/new.twig', [
            'errors' => $errors,
            'token' => $token,
        ]);
    }

    public function deleteAction($token)
    {
        $apiToken = $this->getApiTokenRepository()->findOneByToken($token);
        if (!$apiToken) {
            $this->throw404('That token doesn\'t exist!');
        }

        if ($apiToken->userId != $this->getLoggedInUser()->id) {
            throw new AccessDeniedException('Not your token!');
        }

        $this->getApiTokenRepository()->delete($apiToken);

        $this->setFlash('The token was shown the proverbial "door" (i.e. deleted).');
        $url = $this->generateUrl('user_tokens');

        return $this->redirect($url);
    }
}
