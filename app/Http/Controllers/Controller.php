<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function resSuccess($message = '', $data = []) {
        return response()->json([
            'status' => true, 
            'status_code' => Response::HTTP_OK, 
            'message' => $message, 
            'data' => $data
        ], Response::HTTP_OK);
    }

    protected function resUnauthorized($message = '') {
        return response()->json([
            'status' => false, 
            'status_code' => Response::HTTP_UNAUTHORIZED, 
            'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }

    protected function resNotFound($message = '') {
        return response()->json([
            'status' => false, 
            'status_code' => Response::HTTP_NOT_FOUND, 
            'message' => $message
        ], Response::HTTP_NOT_FOUND);
    }

    protected function resBadRequest($message = '') {
        return response()->json([
            'status' => false, 
            'status_code' => Response::HTTP_BAD_REQUEST, 
            'message' => $message
        ], Response::HTTP_BAD_REQUEST);
    }

    protected function resValidator($message = '') {
        return response()->json([
            'status' => false, 
            'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY, 
            'message' => $message
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function resConflict($message = '') {
        return response()->json([
            'status' => false, 
            'status_code' => Response::HTTP_CONFLICT, 
            'message' => $message
        ], Response::HTTP_CONFLICT);
    }
}
