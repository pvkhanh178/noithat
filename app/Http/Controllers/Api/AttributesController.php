<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attributes;
use App\Repositories\Repository;
use Validator;

class AttributesController extends Controller
{
    protected $model;

    public function __construct(Attributes $model)
    {
       // set the model
        $this->model = new Repository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['Attributes'=>$this->model->all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric|exists:products,id',
            'name' => 'required',
            'description' => '',
            'color' => 'required',
            'size' => 'required',
            'unit' => 'required',
            'slug' => '',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        $this->model->create($validator->validated());
        return response()->json(['msg'=>'Add success'], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(is_numeric($id)){
            $Attributes = $this->model->show($id);
            if($Attributes){
                return response()->json(['Attributes' => $Attributes], 200);
            }
            return response()->json(['msg' => 'Not found'], 404);
        }
        return response()->json(['msg' => 'ID Failed'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(is_numeric($id)){
            $Attributes = $this->model->show($id);
            if($Attributes){
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric|exists:products,id',
                    'name' => 'required',
                    'description' => '',
                    'color' => 'required',
                    'size' => 'required',
                    'unit' => 'required',
                    'slug' => '',
                ]);
                if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()]);
                }
                $Attributes->update($validator->validated());
                return response()->json(['msg'=>'Update success'], 404);
            }
            return response()->json(['msg' => 'Not found'], 404);
        }
        return response()->json(['msg' => 'ID Failed'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_numeric($id)){
            $Attributes = $this->model->show($id);
            if($Attributes){
                $Attributes->delete();
                return response()->json(['msg'=>'Delete success'], 200);
            }
            return response()->json(['msg'=>'Attributes not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
    }
}
