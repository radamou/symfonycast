<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{

    /**
     * @Route("/article", name="page_article")
     */
    public function articleAction()
    {
        return new Response('hello word action is good');
    }
}