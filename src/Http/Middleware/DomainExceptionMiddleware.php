<?php

declare(strict_types=1);

namespace Api\Http\Middleware;

use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class DomainExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @OA\Schema(
     *     schema="Error",
     *     @OA\Property(property="error", type="string"),
     *     example={
     *          "error":"Error description."
     *     }
     * )
     * @OA\Schema(
     *     schema="Conflict",
     *     @OA\Property(property="error", type="string"),
     *     example={
     *          "error":"User with this email already exists."
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
        } catch (\DomainException $exception) {
            return new JsonResponse([
                'error' => $exception->getMessage(),
            ], $exception->getCode() ?: 400);
        }
    }
}
