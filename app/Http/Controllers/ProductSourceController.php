<?php

namespace App\Http\Controllers;

use App\ProductSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DataTables;

class ProductSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_source_list = ProductSource::all();
        return view('product_source.index',compact('product_source_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request){
        $product_source_list = ProductSource::all();
        // echo "<pre>"; print_r($product_source_list); echo "</pre>"; die('end of code');
        return DataTables::of($product_source_list)
        ->addColumn('action', function ($value) {
            $com = "'";
                    $string = $com.trim($value->id).$com.','.$com.$value->name.$com.','.$com.$value->contact_no.$com.','.$com.$value->description.$com;
                return '<a class="btn btn-info btn-sm"  style="color:#ffff;" onclick="Edit('.$string.')">
                              <i class="fas fa-pencil-alt">
                              </i>
                          </a>
                          <a class="btn btn-danger btn-sm"  style="color:ffff!important;"  onclick="Delete('.$value->id.');">
                              <i class="fas fa-trash" style="color: #ffff;">
                              </i>
                            </a>';
        })
        ->rawColumns(['action'])
        ->make(true);
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
                'name' => ['required', 'string', 'max:255'],
                'contact_no' => ['required', 'numeric', 'digits:10', 'unique:product_sources'],
            ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $source = new ProductSource();
        $source->name = $request['name'];
        $source->contact_no = $request['contact_no'];
        $source->description = $request['description'];
        $source->save();
        return redirect('distributer')->with(['success'=> 'Source Added!!']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ProductSource  $productSource
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSource $productSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductSource  $productSource
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSource $productSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductSource  $productSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'contact_no' => ['required', 'numeric', 'digits:10'],
            ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $count = ProductSource::where('contact_no',$request['contact_no'])->count();
        if ($count > 1) {
            return Redirect::back()->with(['error'=> 'Duplicate Source Contact!!']);
        }
        $data = ProductSource::where('id',$request['id'])->first();
        $data->name = $request['name'];
        $data->contact_no = $request['contact_no'];
        $data->description = $request['description'];
        $data->save();
        return Redirect::back()->with(['success'=> 'Source Updated!!']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductSource  $productSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSource $productSource)
    {
        $post =ProductSource::where('id',$_GET['id'])->first();
        if ($post != null) {
            $post->delete();
            return redirect('distributer')->with(['success'=> 'Successfully deleted!!']);
        }
        return redirect('distributer');
    }
}
