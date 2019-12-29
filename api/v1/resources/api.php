<?php

/**
 * @OA\Info(
 *     title="Test Task API",
 *     version="1.0"
 * ),
 *
 * @OA\Server(
 *     description="Test Task API Host",
 *     url="/api/v1"
 * ),
 *
 * @OA\SecurityScheme(
 *      securityScheme="http",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="http",
 *      description="YWRtaW46YWRtaW4= -> base64_encode('admin:admin')"
 * ),
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="JWT.access_token"
 * ),
 *
 * @OA\Schema(
 *     schema="Category",
 *     @OA\Property(
 *         property="public_id",
 *         type="string",
 *         example="cd86bc2"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Name"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Item",
 *     @OA\Property(
 *         property="public_id",
 *         type="string",
 *         example="cd86bc2"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Name"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Error",
 *     @OA\Property(
 *         property="error",
 *         type="string",
 *         example="Error message"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ValidationErrors",
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\Property(
 *             property="attribute",
 *             type="array",
 *             @OA\Items(
 *                 type="string"
 *             )
 *         )
 *     )
 * )
 */

