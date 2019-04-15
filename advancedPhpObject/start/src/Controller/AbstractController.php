<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractController
{
    public function render(Request $request) {
        $attributes = $request->attributes->all();
         \extract($attributes, EXTR_SKIP);
         \ob_start();

         include  \Safe\sprintf(__DIR__.'/../../templates/%s.php',  $request->get('_route'));

        return new Response(ob_get_clean());
    }
}