<?php

declare(strict_types=1);

namespace Api\Http\Middleware;

use Api\Http\ValidationException;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @OA\Schema(
     *     schema="ValidationError",
     *     @OA\Property(property="errors", type="object"),
     *     example={
     *          "errors": {
     *              "password": "This value is too short. It should have 6 characters or more."
     *          }
     *     }
     * )
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            return new JsonResponse([
                'errors' => $exception->getErrors()->toArray(),
            ], 422);
        }
    }
}
