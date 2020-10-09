<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Products;
use App\Models\Materials;
use App\Models\Attributes;
use App\Models\ProductImage;
use App\Repositories\Repository;

class ProductsController extends Controller
{
    protected $model;

    public function __construct(Products $model)
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
        return response()->json(['Products'=>$this->model->all()], 200);
    }
    public function getProductsMaterial($id){
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:materials,id'
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        return response()->json(['Products'=>$this->model->getModel()::where('material_id', $id)->get()], 200);
    }
    public function getProductDetails($id){
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:products,id',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        return response()->json([
            'Product'=>$this->model->getModel()::where('id', $id)->get(),
            'Images'=>$this->model->setModel(new ProductImage())->getModel()::where('product_id', $id)
            ->join('files', 'product_images.file_id', '=', 'files.id')
            ->select('files.*')
            ->get(),
            'Attributes'=>$this->model->setModel(new Attributes())->getModel()::where('product_id', $id)->get()
        ], 200);
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
            'sale_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'model' => 'required',
            'specification' => 'required',
            'material_id' => 'required|numeric|exists:materials,id',
            'description' => '',
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
            $Products = $this->model->show($id);
            if($Products){
                return response()->json(['Products' => $Products], 200);
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
            $Products = $this->model->show($id);
            if($Products){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'sale_price' => 'required|numeric',
                    'cost_price' => 'required|numeric',
                    'model' => 'required',
                    'specification' => 'required',
                    'material_id' => 'required|numeric|exists:materials,id',
                    'description' => '',
                    'slug' => '',
                ]);
                if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()]);
                }
                $Products->update($validator->validated());
                return response()->json(['msg'=>'Update success'], 404);
            }
            return response()->json(['msg' => 'Not found'], 404);
        }
        return response()->json(['msg' => 'ID Products Failed'], 404);
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
            $Products = $this->model->show($id);
            if($Products){
                $Products->delete();
                return response()->json(['msg'=>'Delete success'], 200);
            }
            return response()->json(['msg'=>'Products not found'], 404);
        }
        return response()->json(['msg'=>'ID failed'], 404);
    }
}
