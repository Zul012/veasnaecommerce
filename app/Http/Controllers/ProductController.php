<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Make sure to load the relationships
    $products = Product::with(['brand', 'cat_info', 'sub_cat_info'])->paginate(10);
    return view('backend.product.index')->with('products', $products);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::get();
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.product.create')->with('categories',$category)->with('brands',$brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->validate($request,[
        'title'=>'string|required',
        'summary'=>'string|required',
        'description'=>'string|nullable',
        'photo'=>'string|required', // This is correct for file manager
        'size'=>'nullable',
        'stock'=>"required|numeric",
        'cat_id'=>'required|exists:categories,id',
        'brand_id'=>'nullable|exists:brands,id',
        'child_cat_id'=>'nullable|exists:categories,id',
        'is_featured'=>'sometimes|in:1',
        'status'=>'required|in:active,inactive',
        'condition'=>'required|in:default,new,hot',
        'price'=>'required|numeric',
        'discount'=>'nullable|numeric'
    ]);

    $data = $request->all();
    $slug = Str::slug($request->title);
    $count = Product::where('slug', $slug)->count();
    if($count > 0){
        $slug = $slug.'-'.date('ymdis').'-'.rand(0,999);
    }
    $data['slug'] = $slug;
    $data['is_featured'] = $request->input('is_featured', 0);
    
    $size = $request->input('size');
    if($size){
        $data['size'] = implode(',', $size);
    } else {
        $data['size'] = '';
    }

    // Make sure photo is handled correctly
    if($request->has('photo')) {
        $data['photo'] = $request->photo;
    }

    $status = Product::create($data);
    
    if($status){
        session()->flash('success','Product added');
    } else {
        request()->flash('error','Please try again!!');
    }
    
    return redirect()->route('product.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::get();
        $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$category)->with('items',$items);
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
        $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'brand_id'=>'nullable|exists:brands,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->flash('success','Product updated');
        }
        else{
            request()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->flash('success','Product deleted');
        }
        else{
            request()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
