<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Get user.
     *
     * @OA\Get(
     *     path="/api/v1/user/{id}",
     *     tags={"user"},
     *     operationId="getUser",
     *     summary="Get user by ID",
     *     description="",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="The user ID",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\Schema(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401, 
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404, 
     *         description="User not found",
     *     ),
     *     security={ {"api_key_security" : {} } }
     * )
     */
    public function show(int $id) : JsonResponse
    {
        try {
            $user = $this->repository->getById($id);
            if ($user->id) {
                return response()->json($user, 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                ],
            ], 400);
        }
    }

    /**
     * Store a new user.
     *
     * @OA\Post(
     *     path="/api/v1/user",
     *     tags={"user"},
     *     operationId="addUser",
     *     summary="Add a new user to the API",
     *     description="",
     *     @OA\RequestBody(
     *         description="User object that needs to be added to the API",
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ), 
     *     @OA\Response(
     *         response="201",
     *         description="Successfully created",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *      response=400, 
     *      description="User validation error", 
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="errors",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="The field firstname is required"
     *              ),
     *          ),
     *      ),
     *   ),
     * )
     */
    public function store(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $this->repository->getValidatorRules('store'));
            if ($validator->fails()) { 
                return response()->json([
                    'errors' => $validator->errors(),
                ], 400);
            }

            $saved = $this->repository->create($request->all());
                
            return response()->json($saved, 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                ],
            ], 400);
        }
    }

    /**
     * Update the specified user.
     *
     * @OA\Put(path="/api/v1/user/{id}",
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
     *         type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *       required=true,
     *       description="Updated user object",
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/User")
     *       )
     *   ),
     *   @OA\Response(response=204, description="User updated successfully"),
     *   @OA\Response(
     *      response=400, 
     *      description="User validation error", 
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="errors",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="User not found"
     *              ),
     *          ),
     *      ),
     *   ),
     *   @OA\Response(
     *       response=401, 
     *       description="Unauthorized",
     *   ),
     *   security={ {"api_key_security" : {} } }
     * )
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $this->repository->getValidatorRules('update'));
            if ($validator->fails()) { 
                return response()->json([
                    'errors' => $validator->errors(),
                ], 400);
            }
            $this->repository->update($id, $request->all());

            return response()->json('', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'errors' => [
                    'User not found',
                ],
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                ],
            ], 400);
        }
    }

    /**
     * @OA\Delete(path="/api/v1/user/{id}",
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
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response=202, description="The user was marked for deletion"),
     *   @OA\Response(
     *       response=401, 
     *       description="Unauthorized",
     *   ),
     *   @OA\Response(response=404, description="User not found"),
     *   security={ {"api_key_security" : {} } }
     * )
     */
    public function delete(int $id) : JsonResponse
    {
        try {
            $this->repository->deleteById($id);

            return response()->json('', 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'errors' => [
                    'User not found',
                ],
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                ],
            ], 400);
        }
    }

}
