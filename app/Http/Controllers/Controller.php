<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return error response
     *
     * @param $data
     * @param $status
     * @param $action
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnError($data, $status, $action)
    {
        $errorMsg = '';
        if ($status == 404) {
            $errorMsg = 'There is no ' . $data . ' with this ID.';
        } else if ($status == 503) {
            $errorMsg = 'Failed to ' . $action . ' ' . $data . '. Please try again later.';
        } else if ($status == 403) {
            $errorMsg = 'You do not have permission to ' . $action . '.';
        }

        return $this->returnErrorMessage($status, $errorMsg);
    }

    /**
     * Return error response
     *
     * @param $status
     * @param $errorMsg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnErrorMessage($status, $errorMsg)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $errorMsg
        ], $status);
    }

    /**
     * Return success response
     *
     * @param $key
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnSuccessMessage($key, $data)
    {
        return response()->json([
            'status' => 'success',
            $key => $data
        ], 200);
    }
}
