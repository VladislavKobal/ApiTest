<?php

namespace App\Http\Controllers\Api;

use App\Models\Values;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($key = null)
    {
        if(is_null($key)){
            $products = Values::all();
        }
        else if(!is_array($key)){
            $products = Values::where('key', $key)->get();
        }
        else if(is_array($key)){
            $products = Values::whereIn('key', $key)->get();
        }

        return response()->json([
            "success" => true,
            "message" => "Value List",
            "data" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        /*$validator = Validator::make($input, [
            'key' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }*/
        $product = Values::create($input);
        return response()->json([
            "success" => true,
            "message" => "Value created successfully.",
            "data" => $product
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Values::find($id);
        //if (is_null($product)) {
        //    return $this->sendError('Value not found.');
        //}

        if (is_null($product)) {
            return response()->json([
                "success" => false,
                "message" => "error.",
                "data" => $id
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Value retrieved successfully.",
            "data" => $product
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id)
    {
        $val = Values::find($id);
        if (is_null($val)) {
            return response()->json([
                "success" => false,
                "message" => "error.",
                "data" => $id
            ]);
        }
        $val->key = request("key");
        $val->value = request("value");
        $val->save();

        return response()->json([
            "success" => true,
            "message" => "Value updated successfully.",
            "data" => $val
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $val = Values::find($id);
        if (is_null($val)) {
            return response()->json([
                "success" => false,
                "message" => "error.",
                "data" => $id
            ]);
        }
        $val->delete();
        return response()->json([
            "success" => true,
            "message" => "Value deleted successfully.",
            "data" => $val
        ]);
    }
}
