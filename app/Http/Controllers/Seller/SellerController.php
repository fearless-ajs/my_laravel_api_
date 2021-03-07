<?php

    namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::has('products')->get(); //if the user has at least one product(Buyers doesn't have a table, it extends User model)
        return response()->json(['data' => $sellers, 200]); //200 means response OK
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = Seller::has('products')->findOrFail($id);
        return response()->json(['data' => $seller], 200); //200 means response OK
    }
}
