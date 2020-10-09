<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Files;
use App\Repositories\Repository;
use Validator;

class FilesController extends Controller
{
    protected $model;

    public function __construct(Files $model)
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
        return response()->json(['Files'=>$this->model->all()], 200);
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
            'type' => 'required',
            'obj_type' => 'required',
            'size' => 'required',
            'description' => '',
            'path' => '',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        $this->model->create($validator->validated());
        return response()->json(['msg'=>'Add success'], 200);
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
            $Files = $this->model->show($id);
            if($Files){
                return response()->json(['Files' => $Files], 200);
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
            $Files = $this->model->show($id);
            if($Files){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'type' => 'required',
                    'obj_type' => 'required',
                    'size' => 'required',
                    'description' => '',
                    'path' => '',
                ]);
                if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()]);
                }
                $Files->update($validator->validated());
                return response()->json(['msg'=>'Update success'], 200);
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
            $Files = $this->model->show($id);
            if($Files){
                $Files->delete();
                return response()->json(['msg'=>'Delete success'], 200);
            }
            return response()->json(['msg'=>'Files not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
    }
}
