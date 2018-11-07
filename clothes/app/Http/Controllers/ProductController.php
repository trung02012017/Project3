<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Product;
use App\Category;
use App\Firm;
use App\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->ajax()){
            return response()->json([
                'message'           => "Product is added successfully",
                'class_name'        => 'alert-success'
            ]);
        } else {
            return view('ad-index');
        }
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
        //
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
        $product_id = $id;
        

        $product_name = $request->input('product_name');
        $product_size = $request->input('product_size');
        $product_color = $request->input('product_color');
        $product_quantity = $request->input('product_quantity');
        $product_description = $request->input('product_description');
        $product_price = $request->input('product_price');
        $category_name = $request->input('category_name');
        $firm_name = $request->input('firm_name');

        // $category = Category::where('name', '=', $category_name)->first();
        // $category_id = $category->categoryId;

        // $firm = Firm::where('name', '=', $firm_name)->first();
        // $firm_id = $firm->firmId;

        Product::updateproduct($product_id, $product_name, $product_size, $product_color, $product_quantity, $product_description, $product_price, $category_name, $firm_name);

        // $product->name = $product_name;
        // $product->size = (int)$product_size;
        // $product->color = strtoupper($product_color);
        // $product->quantity = (int)$product_quantity;
        // $product->description = $product_description;
        // $product->price = (int)$product_price;
        // $product->categoryId = $category_id;
        // $product->FirmId = $firm_id;
        // $product->save();

        $message = 'Product updated successfully';
        $url = '/detailproduct/'.$product_id;

        return redirect($url)->with('message', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {   
        $product = Product::find($id);
        $category_name = $product->category->name;

        Product::deleteproduct($id);
        $url = '/productlist/'.$category_name;
        $message = 'Product deleted successfully';
        return redirect($url)->with('message', $message);
    }

    public function showproductlist($kind){
        $category_name = $kind;

        $product_list = Product::getProductByCategory($category_name);

        return view('ad-showproductlist')->with('product_list', $product_list);
    }

    public function showproductdetail($id){
        $id_product = $id;

        $product = Product::getProductById($id);

        return view('ad-showproductdetail')->with('product', $product);
    }

    public function showproductupdate($id){
        $id_product = $id;

        $product = Product::getProductById($id);
        $category_name = Category::select('name')->get();
        $firm_name = Firm::select('name')->get();

        return view('ad-showproductupdate')->with(['product' => $product, 
                                                   'category_name' => $category_name,
                                                   'firm_name' => $firm_name]);
    }

    public function showaddform(){
        $categories = Category::select('name')->get();
        $firms = Firm::select('name')->get();
        return view('ad-addproduct')->with(['categories' => $categories,
                                            'firms'     => $firms]);
    }

    public function addproduct(Request $request){

        // $validation = $request->validate([
        //     'image1' => 'required|image|mimes: jpeg,png,jpg,gif',
        //     'image2' => 'required|image|mimes: jpeg,png,jpg,gif',
        //     'image3' => 'required|image|mimes: jpeg,png,jpg,gif',
        //     'image4' => 'required|image|mimes: jpeg,png,jpg,gif'
        // ]);

        // if($validation->passes()){

        //     $product_name = $request->input('product_name');
        //     $product_size = $request->input('product_size');
        //     $product_color = $request->input('product_color');
        //     $product_quantity = $request->input('product_quantity');
        //     $product_description = $request->input('product_description');
        //     $product_price = $request->input('product_price');
        //     $category_name = $request->input('category_name');
        //     $firm_name = $request->input('firm_name');

        //     $category = Category::where('name', '=', $category_name);
        //     $category_id = $category->id;

        //     $firm = Firm::where('name', '=', $firm_name);
        //     $firm_id = $firm->id;

        //     $new_product = new Product();
        //     $new_product->name = $product_name;
        //     $new_product->size = (int)$product_size;
        //     $new_product->color = strtoupper($product_color);
        //     $new_product->quantity = (int)$product_quantity;
        //     $new_product->desciption = $product_description;
        //     $new_product->price = (int)$product_price;
        //     $new_product->categoryId = $category_id;
        //     $new_product->FirmId = $firm_id;
        //     $new_product->save();
            
        //     $image1 = $request->file('image1');
        //     $new_name1 = $name_img.'_1.'.$image1->getClientOriginalExtension();
        //     $image1->move(public_path('Dresses'), $new_name1);

        //     $image2 = $request->file('image1');
        //     $new_name2 = $name_img.'_2.'.$image2->getClientOriginalExtension();
        //     $image2->move(public_path('Dresses'), $new_name2);

        //     $image3 = $request->file('image3');
        //     $new_name3 = $name_img.'_3.'.$image3->getClientOriginalExtension();
        //     $image3->move(public_path('Dresses'), $new_name3);

        //     $image4 = $request->file('image4');
        //     $new_name4 = $name_img.'_4.'.$image4->getClientOriginalExtension();
        //     $image4->move(public_path('Dresses'), $new_name4);

        //     $new_name1 = 'Dresses'.$new_name1;
        //     $new_name2 = 'Dresses'.$new_name2;
        //     $new_name3 = 'Dresses'.$new_name3;
        //     $new_name4 = 'Dresses'.$new_name4;

        //     $new_image1 = new Image();
        //     $new_image1->productId = $id;
        //     $new_image1->link = $new_name1;
        //     $new_image1->save();

        //     $new_image2 = new Image();
        //     $new_image2->productId = $id;
        //     $new_image2->link = $new_name2;
        //     $new_image2->save();

        //     $new_image3 = new Image();
        //     $new_image3->productId = $id;
        //     $new_image3->link = $new_name3;
        //     $new_image3->save();


        //     $new_image4 = new Image();
        //     $new_image4->productId = $id;
        //     $new_image4->link = $new_name4;
        //     $new_image4->save();

        //     $message = 'abcd';

        //     return view('ad-showproductlist')->with('message', $message);


        // } else {
        //     $message = 'abcd';
        //     return view('ad-addproduct')->with('message', $message);
        // }

        $accepted_kind = array('jpg', 'jepg', 'png');

         $image1 = $request->file('image1');
         $kind1 = $image1->getClientOriginalExtension();

         $image2 = $request->file('image2');
         $kind2 = $image2->getClientOriginalExtension();
        
        $image3 = $request->file('image3');
         $kind3 = $image3->getClientOriginalExtension();
        
        $image4 = $request->file('image4');
         $kind4 = $image4->getClientOriginalExtension();
        
        
        if(in_array($kind1, $accepted_kind) && in_array($kind2, $accepted_kind)  && in_array($kind3, $accepted_kind)  && in_array($kind4, $accepted_kind)){
            $product_name = $request->input('product_name');
            $product_size = $request->input('product_size');
            $product_color = $request->input('product_color');
            $product_quantity = $request->input('product_quantity');
            $product_description = $request->input('product_description');
            $product_price = $request->input('product_price');
            $category_name = $request->input('category_name');
            $firm_name = $request->input('firm_name');

            $category = Category::where('name', '=', $category_name)->first();
            $category_id = $category->categoryId;

            $firm = Firm::where('name', '=', $firm_name)->first();
            $firm_id = $firm->firmId;

            $new_product = new Product();
            $new_product->name = $product_name;
            $new_product->size = (int)$product_size;
            $new_product->color = strtoupper($product_color);
            $new_product->quantity = (int)$product_quantity;
            $new_product->description = $product_description;
            $new_product->price = (int)$product_price;
            $new_product->categoryId = $category_id;
            $new_product->FirmId = $firm_id;
            $new_product->save();


            $max_id = Product::max('productId');
            $id = $max_id;
            $name_img = (string)$id;


            
            $image1 = $request->file('image1');
            $new_name1 = $name_img.'_1.'.$image1->getClientOriginalExtension();
            $image1->move(public_path('Dresses'), $new_name1);

            $image2 = $request->file('image2');
            $new_name2 = $name_img.'_2.'.$image2->getClientOriginalExtension();
            $image2->move(public_path('Dresses'), $new_name2);

            $image3 = $request->file('image3');
            $new_name3 = $name_img.'_3.'.$image3->getClientOriginalExtension();
            $image3->move(public_path('Dresses'), $new_name3);

            $image4 = $request->file('image4');
            $new_name4 = $name_img.'_4.'.$image4->getClientOriginalExtension();
            $image4->move(public_path('Dresses'), $new_name4);

            $new_name1 = 'Dresses/'.$new_name1;
            $new_name2 = 'Dresses/'.$new_name2;
            $new_name3 = 'Dresses/'.$new_name3;
            $new_name4 = 'Dresses/'.$new_name4;

            $new_image1 = new Image();
            $new_image1->productId = $id;
            $new_image1->link = $new_name1;
            $new_image1->save();

            $new_image2 = new Image();
            $new_image2->productId = $id;
            $new_image2->link = $new_name2;
            $new_image2->save();

            $new_image3 = new Image();
            $new_image3->productId = $id;
            $new_image3->link = $new_name3;
            $new_image3->save();


            $new_image4 = new Image();
            $new_image4->productId = $id;
            $new_image4->link = $new_name4;
            $new_image4->save();

            $message = 'Product added successfully';
            $url = '/productlist/'.$category_name;

            return redirect($url)->with('message', $message);
        } else {
            $url = '/ad-addproduct';
            $message = 'Please upload images';
            return redirect($url)->with('message', $message);
        }
    }

}
