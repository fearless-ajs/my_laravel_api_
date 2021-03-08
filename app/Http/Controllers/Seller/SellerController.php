<?php

    namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::has('products')->get(); //if the user has at least one product(Buyers doesn't have a table, it extends User model)
        //Hands over the response to showAll() in ApiResponser class
        return $this->showAll($sellers);
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
        //Hands over the response to showOne() in ApiResponser class
        return $this->showOne($seller); //200 means response OK
    }
}
