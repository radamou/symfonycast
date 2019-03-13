<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class StarShipAction extends AbstractController
{
    public function indexAction(Request $request)
    {
        $this->render($request);
    }
}
