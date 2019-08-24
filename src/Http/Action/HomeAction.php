<?php

declare(strict_types=1);

namespace Api\Http\Action;

use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class HomeAction implements RequestHandlerInterface
{
    private $name;

    private $version;

    public function __construct(string $name, string $version)
    {
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * @OA\Get(
     *     path="/",
     *     tags={"API information"},
     *     summary="Show app name and API version",
     *     operationId="information",
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/ApiVersion")
     *          )
     *     )
     * )
     * @OA\Schema(
     *     schema="ApiVersion",
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="version", type="string"),
     *     example={"name": APP_NAME, "version": APP_VERSION}
     * )
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'name' => $this->name,
            'version' => $this->version,
        ]);
    }
}
