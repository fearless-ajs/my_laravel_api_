<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /*
     *  Api response codes
     * ----------------------
     *  200 means response OK
     *  201 means data created
     */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return response()->json(['data' => $collection], $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return response()->json(['data' => $model] , $code);
    }

}
