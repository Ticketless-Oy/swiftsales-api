<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as Controller;
use Illuminate\Http\Request;
use App\Managers\AuthManager\AuthManager;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use App\Exceptions\NotFoundException\NotFoundException;
use App\Exceptions\CustomValidationException\CustomValidationException;

class BaseController extends Controller
{


    const RESOURCE_MODEL = "";

    protected string $CRUD_RESPONSE_ARRAY = "";
    protected string $CRUD_RESPONSE_OBJECT = "";

    protected function createResponseData(mixed $data, string $type): array
    {
        if ($type == "array") {
            return [
                $this->CRUD_RESPONSE_ARRAY => $data
            ];
        }
        if ($type == "object") {
            return [
                $this->CRUD_RESPONSE_OBJECT => $data
            ];
        }

        throw new Exception("Invalid response type");
    }

    protected function handleError(Exception $e): JsonResponse
    {
        $statusCode = ($e->getCode() ? $e->getCode() : 500);
        return response()->json(['error' => $e->getMessage()], $statusCode);
    }

    protected function verifyAccessToResource(int $userID, Request $request): void
    {
        $authManager = new AuthManager();
        $authManager->verifyAccess($userID, $request);
    }

    public function getAllByUserID(int $userID, Request $request): JsonResponse
    {
        try {
            $model = app(static::RESOURCE_MODEL);
            $this->verifyAccessToResource($userID, $request);
            $resources = $model::where('userID', $userID)->get();

            $response = $this->createResponseData($resources, 'array');
            return response()->json($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    public function getSingle(int $resourceID, Request $request): JsonResponse
    {
        try {
            $model = app(static::RESOURCE_MODEL);
            $modelPrimaryKey = $model->getPrimaryKeyName();
            $resource = $model::where($modelPrimaryKey, $resourceID)->first();

            if (!$resource) {
                throw new NotFoundException('Company not found');
            }

            $userIDInResource = $resource->userID;
            $this->verifyAccessToResource($userIDInResource, $request);
            $response = $this->createResponseData($resource, 'object');
            return response()->json($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    public function deleteSingle(Request $request): JsonResponse
    {
        try {
            $model = app(static::RESOURCE_MODEL);
            $modelPrimaryKey = $model->getPrimaryKeyName();

            if (!$request->json($modelPrimaryKey)) {
                throw new CustomValidationException($modelPrimaryKey . ' is required');
            }

            $resourceID = $request->json($modelPrimaryKey);
            $resource = $model::where($modelPrimaryKey, $resourceID)->first();

            if (!$resource) {
                throw new NotFoundException('Resource not found');
            }

            $userIDInResource = $resource->userID;
            $this->verifyAccessToResource($userIDInResource, $request);
            $resource->delete();
            return response()->json(['success' => 'Resource deleted']);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }
}
