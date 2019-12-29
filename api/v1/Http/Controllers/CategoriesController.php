<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Entities\CategoryEntity;
use Api\V1\Http\Requests\CreateCategoryRequest;
use Api\V1\Http\Requests\UpdateCategoryRequest;
use Api\V1\Repositories\CategoryRepository;
use Api\V1\Repositories\ItemRepository;
use Api\V1\Rules\UniqueCategoryItemRule;
use Api\V1\Services\SwapCategoryService;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['view',  'list', 'getItems',]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/category/{public_id}/item",
     *     summary="View items in the category",
     *     tags={"category"},
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
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Item")
     *         ),
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
     * @param CategoryRepository $repository
     *
     * @return array
     */
    public function getItems($public_id, CategoryRepository $repository)
    {
        return $repository->findByPublicId($public_id)->items;
    }

    /**
     * @OA\Post(
     *     path="/category/{public_id}/item",
     *     summary="Add the item to the category",
     *     tags={"category"},
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
     *                     property="Item.public_id",
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
     * @param string $public_id
     * @param CategoryRepository $categoryRepository
     * @param ItemRepository $itemRepository
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function addItem(
        $public_id,
        CategoryRepository $categoryRepository,
        ItemRepository $itemRepository,
        Request $request,
        Response $response
    )
    {
        $category = $categoryRepository->findByPublicId($public_id);
        $item = $itemRepository->findByPublicId($request->post('Item_public_id'));
        $validator = Validator::make(
            ['public_id' => $public_id],
            ['public_id' => new UniqueCategoryItemRule($category->id, $item->id)]
        );
        $validator->validate();
        $category->items()->attach($item->id);

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Put(
     *     path="/category/{public_id}",
     *     summary="Swap the categories",
     *     tags={"category"},
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
     *                     property="public_id",
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
     *     )
     * )
     *
     * @param string $public_id
     * @param CategoryRepository $repository
     * @param Request $request
     * @param SwapCategoryService $service
     * @param Response $response
     *
     * @return Response
     * @throws \Throwable
     */
    public function swap(
        $public_id,
        CategoryRepository $repository,
        Request $request,
        SwapCategoryService $service,
        Response $response
    )
    {
        $from = $repository->findByPublicId($public_id);
        $to = $repository->findByPublicId($request->post('public_id'));

        $service->swap($from, $to);

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Delete(
     *     path="/category/{public_id}",
     *     summary="Delete the category with children",
     *     tags={"category"},
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
     * @param CategoryRepository $repository
     * @param Response $response
     *
     * @return Response
     * @throws \Exception
     */
    public function delete($public_id, CategoryRepository $repository, Response $response)
    {
        $repository->findByPublicId($public_id)->delete();

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Patch(
     *     path="/category/{public_id}",
     *     summary="Update the category",
     *     tags={"category"},
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
     * @param UpdateCategoryRequest $request
     * @param CategoryRepository $repository
     * @param Response $response
     *
     * @return Response
     * @throws \Throwable
     */
    public function update(
        $public_id,
        UpdateCategoryRequest $request,
        CategoryRepository $repository,
        Response $response
    )
    {
        $data = $request->validated();

        $entity = $repository->findByPublicId($public_id);
        $entity->name = $data['name'];
        $entity->saveOrFail();

        return $response->setStatusCode($response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/category/{parent_id}",
     *     summary="Create the subcategory",
     *     tags={"category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="parent_id",
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
     *         response="201",
     *         description="Created",
     *         @OA\Header(
     *             header="Location",
     *             @OA\Schema(type="string"),
     *             description="The link to new resource (/api/v1/category/{public_id})"
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
     * @param string $public_id
     * @param CategoryRepository $repository
     * @param CreateCategoryRequest $request
     * @param Response $response
     * @param UrlGenerator $urlGenerator
     *
     * @return Response
     * @throws \Throwable
     */
    public function createChild(
        $public_id,
        CategoryRepository $repository,
        CreateCategoryRequest $request,
        Response $response,
        UrlGenerator $urlGenerator
    )
    {
        $childAttributes = $request->validated();
        $parent = $repository->findByPublicId($public_id);
        $childAttributes['parent_id'] = $parent->id;

        $child = new CategoryEntity($childAttributes);
        $child->saveOrFail();

        $resource = $urlGenerator->to('api/v1/category', [$child->public_id]);

        return $response
            ->setStatusCode($response::HTTP_CREATED)
            ->header('Location', $resource);
    }

    /**
     * @OA\Get(
     *     path="/category/{public_id}",
     *     summary="View the category",
     *     tags={"category"},
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
     *         @OA\JsonContent(ref="#/components/schemas/Category")
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
     * @param CategoryRepository $repository
     *
     * @return array
     */
    public function view($public_id, CategoryRepository $repository)
    {
        return $repository->findByPublicId($public_id)->toArray();
    }

    /**
     * @OA\Get(
     *     path="/category",
     *     summary="View the categories",
     *     tags={"category"},
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
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="Not Acceptable",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     )
     * )
     * @param CategoryRepository $repository
     *
     * @return array
     */
    public function list(CategoryRepository $repository)
    {
        return $repository->asTree();
    }

    /**
     * @OA\Post(
     *     path="/category",
     *     summary="Create the category",
     *     tags={"category"},
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
     *             description="The link to new resource (/api/v1/category/{public_id})"
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
     * @param CreateCategoryRequest $request
     * @param Response $response
     * @param UrlGenerator $urlGenerator
     *
     * @return Response
     * @throws \Throwable
     */
    public function create(CreateCategoryRequest $request, Response $response, UrlGenerator $urlGenerator)
    {
        $entity = new CategoryEntity($request->validated());
        $entity->saveAsRoot();

        $resource = $urlGenerator->to('api/v1/category', [$entity->public_id]);

        return $response
            ->setStatusCode($response::HTTP_CREATED)
            ->header('Location', $resource);
    }
}
