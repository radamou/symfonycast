<?php

namespace KnpU\CodeBattle\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiProblemResponseFactory
{
    public static function createResponse(ApiProblem $problem): JsonResponse
    {
        $data = $problem->toArray();

        if ('about:blank' !== $data['type']) {
            $data['type'] = 'http://localhost:8000/api/docs/errors#'.$data['type'];
        }

        $response = new JsonResponse(
            $data,
            $problem->getStatusCode()
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }
}
