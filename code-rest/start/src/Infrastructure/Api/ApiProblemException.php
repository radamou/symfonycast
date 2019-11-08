<?php

namespace KnpU\Infrastructure\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    private $apiProblem;

    public function __construct(
        ApiProblem $apiProblem,
        \Exception $previous = null,
        array $headers = [],
        $code = 0
    ) {
        $this->apiProblem = $apiProblem;

        parent::__construct(
            $apiProblem->getStatusCode(),
            $apiProblem->getTitle(),
            $previous,
            $headers,
            $code
        );
    }

    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}
