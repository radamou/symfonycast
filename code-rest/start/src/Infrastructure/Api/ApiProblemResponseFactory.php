<?php

namespace KnpU\Infrastructure\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiProblemResponseFactory
{
    const DEFAULT_VALUE = 'http://localhost:8000/api/docs/errors#';

    public static function createResponse(ApiProblem $problem): JsonResponse
    {
        $data = $problem->toArray();

        if ('about:blank' !== $data['type']) {
            $data['type'] = self::DEFAULT_VALUE.$data['type'];
        }

        $response = new JsonResponse(
            $data,
            $problem->getStatusCode()
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }
}
