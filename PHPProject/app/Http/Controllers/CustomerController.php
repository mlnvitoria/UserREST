<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $repository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->repository = $customerRepository;
    }

    /**
     * Show all customers.
     *
     * @OA\Get(
     *     path="/api/v1/customer",
     *     tags={"Customer"},
     *     operationId="showAllCustomers",
     *     summary="Get customers",
     *     description="",
     *     @OA\Parameter(
     *          in="query",
     *          name="enabled",
     *          required=false,
     *          @OA\Schema(
     *              type="boolean"
     *          ),
     *          description="Returns only enabled customers if enabled=true. Default: filter disabled.",
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="page",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="The number of page for customers. Default: 1",
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="limit",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="The numbers of items to return. Default: 10",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\Schema(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=401, 
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404, 
     *         description="Customer not found",
     *     ),
     *     security={ {"api_key_security" : {} } }
     * )
     */
    public function index(Request $request) : JsonResponse
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $enabled = $request->get('enabled', null);
            
            $customers = $this->repository->get($page, $limit, $enabled);
            
            return response()->json($customers, 200);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                ],
            ], 400);
        }
    }

    /**
     * Show customer.
     *
     * @OA\Get(
     *     path="/api/v1/customer/{id}",
     *     tags={"Customer"},
     *     operationId="showCustomer",
     *     summary="Get customer by ID",
     *     description="",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          description="The customer ID",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\Schema(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=401, 
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404, 
     *         description="Customer not found",
     *     ),
     *     security={ {"api_key_security" : {} } }
     * )
     */
    public function show(int $id) : JsonResponse
    {
        try {
            $customer = $this->repository->getById($id);
            if ($customer->id) {
                return response()->json($customer, 200);
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
     * Store a new customer.
     *
     * @OA\Post(
     *     path="/api/v1/customer",
     *     tags={"Customer"},
     *     operationId="addCustomer",
     *     summary="Add a new customer",
     *     description="",
     *     @OA\RequestBody(
     *         description="Customer object that needs to be added to the API",
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/Customer")
     *         )
     *     ), 
     *     @OA\Response(
     *         response="201",
     *         description="Successfully created",
     *     ),
     *     @OA\Response(
     *      response=400, 
     *      description="Customer validation error", 
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="errors",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="The field name is required"
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
     * Update the specified customer.
     *
     * @OA\Put(path="/api/v1/customer/{id}",
     *   tags={"Customer"},
     *   summary="Update customer",
     *   description="This can only be done by the logged in user.",
     *   operationId="updateCustomer",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The customer ID that need to be updated",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *       required=true,
     *       description="Updated customer object",
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/Customer")
     *       )
     *   ),
     *   @OA\Response(response=204, description="Customer updated successfully"),
     *   @OA\Response(
     *      response=400, 
     *      description="Customer validation error", 
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="errors",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="Customer not found"
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

            $updated = $this->repository->update($id, $request->all());

            if ($updated->wasChanged()) {
                return response()->json('', 204);
            }

            return response()->json('', 500);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'errors' => [
                    'Customer not found',
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
     * @OA\Delete(path="/api/v1/customer/{id}",
     *   tags={"Customer"},
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
     *   @OA\Response(response=202, description="The customer was marked for deletion"),
     *   @OA\Response(
     *       response=401, 
     *       description="Unauthorized",
     *   ),
     *   @OA\Response(response=404, description="Customer not found"),
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
                    'Customer not found',
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
