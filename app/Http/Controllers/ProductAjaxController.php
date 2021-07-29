<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use File;
use Storage;
use Exception;

class ProductAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        try { 
            $logged_user_id = \Auth::user()->id;
            if ($request->ajax()) {
                
                $data = Product::where('created_by',$logged_user_id)->latest()->get();
                
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                            return $btn;
                        })
                        ->addColumn('image', function ($img) {
                            return '<img src="'.$img->image.'" border="0" width="100" class="img-rounded" align="center" />';
                        })
                        ->rawColumns(['image','action'])
                        ->make(true);
            }
        
            return view('productAjax');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // dd($request->all());
        try{
            if($request->hasFile('image')) {
                $contenet   = file_get_contents($request->image->getRealPath());
                $file_name  = rand().time().rand(1,99).".jpeg";
                $file_move  = Storage::disk('public')->put($file_name,$contenet);
            } else {
                if($request->product_id == '') {
                    $file_move      = false;
                }else {
                    $file_move      = true;
                    $productDetails = Product::find($request->product_id);
                    $segments       = explode('/', $productDetails->image);
                    $file_name      = $segments[count($segments)-1];
                }
            }

            $logged_user_id = \Auth::user()->id;

            Product::updateOrCreate(
                ['id' => $request->product_id],
                [
                    'name'          => $request->name, 
                    'detail'        => $request->detail, 
                    'created_by'    => $logged_user_id,
                    'image'         => ($file_move == true) ? $file_name : ''
                ]
            );        
    
            return response()->json(['success'=>'Product saved successfully.']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        try{
            $product = Product::find($id);
            return response()->json($product);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        try{ 
            Product::find($id)->delete();
            return response()->json(['success'=>'Product deleted successfully.']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}