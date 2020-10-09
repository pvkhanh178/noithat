<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Materials;
use App\Repositories\Repository;

class MaterialsController extends Controller
{
    protected $model;

    public function __construct(Materials $model)
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
        return response()->json(['Materials'=>$this->model->all()], 200);
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
            'name' => 'required',
            'description'=>'',
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
            $Materials = $this->model->show($id);
            if($Materials){
                return response()->json(['Materials' => $Materials], 200);
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
            $Materials = $this->model->show($id);
            if($Materials){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'description'=>'',
                ]);
                if($validator->fails()){
                    return response()->json(['msg'=>$validator->errors()]);
                }
                $Materials->update($request->all());
                return response()->json(['msg' => 'Update success', 'Materials'=>$Materials], 200);
            }
            return response()->json(['msg'=>'Materials not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
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
            $Materials = $this->model->show($id);
            if($Materials){
                $Materials->delete();
                return response()->json(['msg'=>'Delete success'], 200);
            }
            return response()->json(['msg'=>'Materials not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
    }
}
