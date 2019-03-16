<?php

namespace App\Presentation\Battle;

use Symfony\Component\HttpFoundation\Request;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StarShipAction extends AbstractController
{
    public function indexAction(Request $request)
    {
        return $this->render($request);
    }
}
