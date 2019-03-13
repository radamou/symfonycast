<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractController
{
    public function render(Request $request) {
         \extract($request->attributes->all(), EXTR_SKIP);
         \ob_start();

         include  \sprintf(__DIR__.'/../../templates/%s.php',  $_route);

        return new Response(ob_get_clean());
    }
}