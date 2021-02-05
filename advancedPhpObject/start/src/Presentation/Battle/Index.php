<?php

namespace App\Presentation\Battle;

use Symfony\Component\HttpFoundation\Request;
use App\Presentation\Absract;

class Index extends Absract
{
    public function __invoke(Request $request)
    {
        return $this->render($request);
    }
}
