<?php

namespace App\Presentation\Home;

use App\Presentation\Absract;
use Symfony\Component\HttpFoundation\Request;

class Index extends Absract
{
    public function __invoke(Request $request)
    {
        return $this->render($request);
    }
}