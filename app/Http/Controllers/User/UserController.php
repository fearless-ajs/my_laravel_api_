<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200); //200 means response OK
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed'
        ];
        $this->validate($request, $rules); //Validates the request using the rules we set
        $data = $request->all();

        //Data that needs to be mutated
        $data['password']          = bcrypt($request->password);
        $data['verified']          = User::UNVERIFIED_USER;
        $data['verification_toke'] = User::generateVerificationCode();
        $data['admin']             = User::REGULAR_USER;

        $user = User::create($data);
        return response()->json(['data' => $user], 201); //201 means data created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'email'     => 'email|email|unique:users, email,'. $user->id, //Except the current emat
            'password'  => 'min:6|confirmed',
            'admin'     => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER, //Select between the two values
        ];

        //Check for the updateable fields
        if ($request->has('name')){
            $user->name = $request->name; //Update the name field to the new nam coming fro the request
        }
        if($request->has('email') && $user->email != $request->email){
            //Update all the neccessary field
            $user->verify = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if($request->has('password')){
            $user->password = bcrypt($request->password);

        }
        if($request->has('admin')){
            if(!$user->isVerified()){
                return response()->json(['error' => 'only verified users can modify the admin field', 'code' => 409], 409);
            }
            $user->admin = $request->admin; //makes changes to the field.

        }

        //Tells the user something has been changed
        if(!$user->isDirty()){
            return response()->json(['error' => 'You have to specify a different value to update', 'code' => 422], 422);
        }
        //Otherwise Save the changes
        $user->save();
        //Then the instance of the saved data
        return response()->json(['data' => $user], 200); //200 means response OK
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        //Then the instance of the deleted data
        return response()->json(['data' => $user], 200); //200 means response OK
    }
}
