<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attachment;
use Illuminate\Http\Request;

use App\Http\Resources\ProductResource;
use App\Http\Requests\StepOne;
use App\Http\Requests\StepTwo;
use App\Http\Requests\StepThree;

use Auth;
use Session;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(
            Product::select(['id','name','category_id','description','date_added'])
            ->with('categories:id,category')->orderBy('created_at','desc')->paginate(15)
        );
    }
    public function filter($id)
    {
        return ProductResource::collection(
            Product::select(['id','name','category_id','description','date_added'])->with('categories:id,category')
            ->when($id > 0,function($query) use ($id){
            return $query->where('category_id',$id);
        })->paginate(15));
    }
    public function search(Request $request)
    {
        return ProductResource::collection(
            Product::select(['id','name','category_id','description','date_added'])->with('categories:id,category')
            ->when($request->search,function($query) use($request){
            return $query->where('name','LIKE','%'.$request->search.'%')->orWhere('description','LIKE','%'.$request->search.'%');
        })->paginate(15));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->preparedResponseSuccess(new ProductResource(
            Product::select(['id','name','category_id','description','date_added'])
            ->with('attachments:filename,attachable_type,attachable_id,id')
            ->with('categories:id,category')->find($id)
        ),'edit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StepThree $request, Product $product)
    {
        $product->fill([
            'name'        => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'date_added'  => $request->date_added
        ]);
        $return = $product->save();
            
        Session::forget('products');
        return response()->json($this->preparedResponseSuccess($return,'Return to Product List'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json($this->preparedResponseSuccess([],'Product Deleted'));
    }
    public function loadStep1(Request $request)
    {
        if(Session::has('products'))
        {
            return response()->json($this->preparedResponseSuccess(Session::get('products'),'retrieved'));
        }
        return response()->json($this->preparedResponseSuccess(['name' => null,'category_id' => '','description' => ''],'reset data'));
    }
    public function step1(StepOne $request)
    {
        return response()->json($this->preparedResponseSuccess([],'Proceed to Step 2'));
    }
    public function step2(StepTwo $request)
    {
        return response()->json($this->preparedResponseSuccess([],'Proceed to Step 3'));
    }
    public function step3(StepThree $request)
    {
        $file  = $request->file;    
        $product = new Product;
        $product->fill($request->validated());
        $product->user_id = Auth::user()->id;
        $return = $product->save();
        foreach($file as $key)
        {
            $fileName = time().'.'.$key->extension();
            $filePath = $key->storeAs('uploads', $fileName, 'public');
            $product->attachments()->create(['filename' => $fileName, 'path' => $filePath,'user_id' => Auth::user()->id]);
        }
            
        return response()->json($this->preparedResponseSuccess($return,'Return to Product List'));
    }
    public function updateAttachment(Request $request)
    {
        $product = Product::select('id')->find($request->id);
        $file  = $request->file;
        if($file)
        {
            $product->attachments()->delete();
            foreach($file as $key)
            {
                $fileName = time().'.'.$key->extension();
                $filePath = $key->storeAs('uploads', $fileName, 'public');
                $product->attachments()->create(['filename' => $fileName, 'path' => $filePath,'user_id' => Auth::user()->id]);
            }    
        }            
        return response()->json($this->preparedResponseSuccess([],'Return to Product List'));
    }
}
