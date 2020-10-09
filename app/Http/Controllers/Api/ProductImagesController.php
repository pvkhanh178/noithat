<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Repositories\Repository;
use Validator;

class ProductImagesController extends Controller
{
    protected $model;

    public function __construct(ProductImage $model)
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
        return response()->json(['ProductImages'=>$this->model->all()], 200);
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
            'file_id' => 'required|numeric|exists:files,id',
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
            $ProductImages = $this->model->show($id);
            if($ProductImages){
                return response()->json(['ProductImages' => $ProductImages], 200);
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
            $ProductImages = $this->model->show($id);
            if($ProductImages){
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric|exists:products,id',
                    'file_id' => 'required|numeric|exists:files,id',
                ]);
                if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()]);
                }
                $this->model->create($validator->validated());
                return response()->json(['msg'=>'Add success'], 200);
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
            $ProductImages = $this->model->show($id);
            if($ProductImages){
                $ProductImages->delete();
                return response()->json(['msg'=>'Delete success'], 200);
            }
            return response()->json(['msg'=>'ProductImages not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
    }
}
