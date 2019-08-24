<?php

declare(strict_types=1);

namespace Api\Http\Action\Auth\SignUp;

use Api\Http\ValidationException;
use Api\Http\Validator\Validator;
use Api\Model\User\UseCase\SignUp\Request\Command;
use Api\Model\User\UseCase\SignUp\Request\Handler;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class RequestAction implements RequestHandlerInterface
{
    /**
     * @var Handler
     */
    private $handler;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * RequestAction constructor.
     *
     * @param Handler   $handler
     * @param Validator $validator
     */
    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    /**
     * @OA\Post(
     *     path="/auth/signup",
     *     tags={"Authorization"},
     *     summary="Register for a new user",
     *     operationId="registration",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/SignUp")
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/SignUpSuccess")
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/Error")
     *          )
     *     ),
     *     @OA\Response(
     *          response="409",
     *          description="Conflict",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/Conflict")
     *          )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *          )
     *     )
     * )
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = $this->deserialize($request);

        if ($errors = $this->validator->validate($command)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($command);

        return new JsonResponse([
            'email' => $command->email,
        ], 201);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Command
     */
    private function deserialize(ServerRequestInterface $request): Command
    {
        $body = $request->getParsedBody();

        $command = new Command();

        $command->email = $body['email'] ?? '';
        $command->password = $body['password'] ?? '';

        return $command;
    }
}
