<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\BearerTokenParserService;
use Api\V1\Services\JwtTokenService;
use Illuminate\Routing\Controller;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/auth",
     *     summary="Get JWT",
     *     tags={"auth"},
     *     security={{"http":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="JWT item",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 example="bearer"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Invalid credentials",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     )
     * )
     * @param BearerTokenParserService $bearerTokenParser
     * @param JwtTokenService $jwtTokenService
     *
     * @return array
     */
    public function index(BearerTokenParserService $bearerTokenParser, JwtTokenService $jwtTokenService)
    {
        $bearerTokenCredentials = $bearerTokenParser->credentials();
        try {
            $jwtTokenItem = $jwtTokenService->item($bearerTokenCredentials);
        } catch (UnauthorizedException $e) {
            throw new UnauthorizedHttpException(
                'Basic realm="Test Task API"',
                'Invalid credentials'
            );
        }

        return $jwtTokenItem->toArray();
    }
}
