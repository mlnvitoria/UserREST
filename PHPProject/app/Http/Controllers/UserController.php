<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    /**
     * Store a new user.
     *
     * @OA\Post(
     *     path="/user",
     *     tags={"user"},
     *     operationId="addUser",
     *     summary="Add a new user to the API",
     *     description="",
     *     @OA\RequestBody(
     *         description="User object that needs to be added to the API",
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ), 
     *     @OA\Response(
     *         response="201",
     *         description="successful created",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *     security={{"petstore_auth":{"write:pets", "read:pets"}}}
     * )
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        //
    }

    /**
     * Update the specified user.
     *
     * @OA\Put(path="/user/{id}",
     *   tags={"user"},
     *   summary="Update user",
     *   description="This can only be done by the logged in user.",
     *   operationId="updateUser",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user ID that need to be updated",
     *     required=true,
     *     @OA\Schema(
     *         type="int"
     *     )
     *   ),
     *   @OA\Response(response=400, description="Invalid user supplied"),
     *   @OA\Response(response=404, description="User not found"),
     *   @OA\RequestBody(
     *       required=true,
     *       description="Updated user object",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(ref="#/components/schemas/User")
     *       )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Delete(path="/user/{id}",
     *   tags={"user"},
     *   summary="Delete user",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteUser",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user ID that needs to be deleted",
     *     required=true,
     *     @OA\Schema(
     *         type="int"
     *     )
     *   ),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    public function deleteUser()
    {
    }
}
