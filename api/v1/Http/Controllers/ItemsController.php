<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Entities\ItemEntity;
use Api\V1\Http\Requests\CreateItemRequest;
use Api\V1\Http\Requests\UpdateItemRequest;
use Api\V1\Repositories\ItemRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ItemsController extends Controller
{
    //TODO: 404 msg dlea neshushestvuishego url'a
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['view']
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/item/{public_id}",
     *     summary="Delete the item",
     *     tags={"item"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="public_id",
     *         in="path",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="No Content",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     )
     * )
     *
     * @param string $public_id
     * @param ItemRepository $repository
     * @param Response $response
     *
     * @return Response
     * @throws \Exception
     */
    public function delete($public_id, ItemRepository $repository, Response $response)
    {
        $repository->findByPublicId($public_id)->delete();

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Patch(
     *     path="/item/{public_id}",
     *     summary="Update the item",
     *     tags={"item"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="public_id",
     *         in="path",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="No Content",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable entity",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrors")
     *     )
     * )
     *
     * @param string $public_id
     * @param UpdateItemRequest $request
     * @param ItemRepository $repository
     * @param Response $response
     *
     * @return Response
     * @throws \Throwable
     */
    public function update($public_id, UpdateItemRequest $request, ItemRepository $repository, Response $response)
    {
        $data = $request->validated();

        $entity = $repository->findByPublicId($public_id);
        $entity->name = $data['name'];
        $entity->saveOrFail();

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/item/{public_id}",
     *     summary="View the item",
     *     tags={"item"},
     *     @OA\Parameter(
     *          name="public_id",
     *          in="path",
     *          required=true,
     *     ),
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="Not Acceptable",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     )
     * )
     * @param string $public_id
     * @param ItemRepository $repository
     *
     * @return array
     */
    public function view($public_id, ItemRepository $repository)
    {
        return $repository->findByPublicId($public_id)->toArray();
    }

    /**
     * @OA\Post(
     *     path="/item",
     *     summary="Create the item",
     *     tags={"item"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\Header(
     *             header="Location",
     *             @OA\Schema(type="string"),
     *             description="The link to new resource (/api/v1/item/{public_id})"
     *        )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable entity",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrors")
     *     )
     * )
     *
     * @param CreateItemRequest $request
     * @param Response $response
     * @param UrlGenerator $urlGenerator
     *
     * @return Response
     * @throws \Throwable
     */
    public function create(CreateItemRequest $request, Response $response, UrlGenerator $urlGenerator)
    {
        $entity = new ItemEntity($request->validated());
        $entity->saveOrFail();

        $resource = $urlGenerator->to('api/v1/item', [$entity->public_id]);

        return $response
            ->setStatusCode($response::HTTP_CREATED)
            ->header('Location', $resource);
    }
}
