<?php

/**
 * Swagger (OpenApi\Annotations)
 */

/**
 * @OA\Info(
 *     title="Nuvemshop - PHP RESTful API Template",
 *     description="A RESTful API template built with PHP 8.2 driven by Mezzio framework.",
 *     version="1.0.0",
 * )
 */

/**
 * ----------------------------------------------------------------------------------------------------------------
 * @OA\Tag(
 *     name="Users",
 *     description="Methods for operations with user resources.",
 * )
 * ----------------------------------------------------------------------------------------------------------------
 */

/**
 * @OA\Get(
 *     path="/api/v1/users",
 *     tags={"Users"},
 *     summary="List users",
 *     description="Allows querying data from a list of users.",
 *     @OA\Parameter(
 *         name="filter",
 *         in="query",
 *         description="Filters by properties",
 *         required=false,
 *         @OA\JsonApiSchema(
 *             type="array",
 *             @OA\Items(type="object")
 *         ),
 *         style="form"
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         description="SortTrait the results",
 *         required=false,
 *         @OA\JsonApiSchema(
 *             type="array",
 *             @OA\Items(type="object")
 *         ),
 *         style="form",
 *         example="{id:DESC, createdAt:ASC}"
 *     ),
 *     @OA\Parameter(
 *         name="size",
 *         in="query",
 *         description="Max results per request",
 *         required=false,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="number",
 *         in="query",
 *         description="Result offset",
 *         required=false,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Successfully performed operation",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/UserListResponse")
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/v1/users",
 *     tags={"Users"},
 *     summary="Create user",
 *     description="Allows the creation of a user.",
 *     @OA\RequestBody(
 *         description="Object to be created",
 *         required=true,
 *         @OA\MediaType(
 *           mediaType="application/json",
 *           @OA\JsonApiSchema(ref="./schemas.yaml#/components/schemas/UserCreateRequest")
 *         )
 *     ),
 *     @OA\Response(response="201", description="Successfully performed operation",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/UserCreateResponse")
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Get user",
 *     description="Allows you to consult the data of the user corresponding to the entered ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Successfully performed operation",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/UserReadResponse")
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */

/**
 * @OA\Patch(
 *     path="/api/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Update user",
 *     description="Allows you to update data for a particular user.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\RequestBody(
 *         description="Object to be updated",
 *         required=true,
 *         @OA\MediaType(
 *           mediaType="application/json",
 *           @OA\JsonApiSchema(ref="./schemas.yaml#/components/schemas/UserUpdateRequest")
 *         )
 *     ),
 *     @OA\Response(response="202", description="Successfully performed operation",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/UserUpdateResponse")
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */

/**
 * @OA\Delete (
 *     path="/api/v1/users/{id}",
 *     tags={"Users"},
 *     summary="Delete user",
 *     description="Allows you to exclude a particular user.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\Response(response="204", description="Successfully performed operation",
 *         @OA\JsonContent()
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/v1/users/{id}/roles",
 *     tags={"Users"},
 *     summary="Get user role",
 *     description="Allows you to consult the data of the role of the corresponding user ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\JsonApiSchema(
 *             type="integer",
 *             format="int32"
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Successfully performed operation",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/RoleReadResponse")
 *     ),
 *     @OA\Response(response="422", description="Invalid argument",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="404", description="Resource not found",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(response="400", description="Internal error",
 *         @OA\JsonContent(ref="./schemas.yaml#/components/schemas/ErrorResponse")
 *     )
 * )
 */
