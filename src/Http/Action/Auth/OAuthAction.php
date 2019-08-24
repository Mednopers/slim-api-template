<?php

declare(strict_types=1);

namespace Api\Http\Action\Auth;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response;

/**
 * Class OAuthAction
 *
 * @package Api\Http\Action\Auth
 *
 * @OA\Server(url=APP_HOST)
 * @OA\Info(
 *     title=APP_NAME,
 *     version=APP_VERSION,
 *     @OA\Contact(email=APP_SUPPORT_EMAIL)
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class OAuthAction implements RequestHandlerInterface
{
    private $server;

    private $logger;

    public function __construct(AuthorizationServer $server, LoggerInterface $logger)
    {
        $this->server = $server;
        $this->logger = $logger;
    }

    /**
     * @OA\Post(
     *     path="/oauth/auth",
     *     tags={"Authorization"},
     *     summary="Login user into system.",
     *     description="API Login. Return the access and refresh tokens.",
     *     operationId="login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/AccessTokenParameters")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/AuthorizationSuccess")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/AuthorizationFailure")
     *         )
     *     )
     * )
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            return $this->server->respondToAccessTokenRequest($request, new Response());
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), ['exception' => $exception]);

            return $exception->generateHttpResponse(new Response());
        } catch (\Exception $exception) {
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse(new Response());
        }
    }
}
