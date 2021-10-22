<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('users')
            ->orderBy('id', 'desc')
            ->paginate(50);
        // return Product::all();
        // return $products;

        return response($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->tokenCan("1"))
        {
            $request->validate([
                'name'  => 'required|min:5',
                'slug'  => 'required',
                'price' => 'required',
            ]);

            $data_product = array(
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'slug'        => $request->input('slug'),
                'price'       => $request->input('price'),
                'user_id'     => $user->id,
                // 'image' =>
            );

            //รับไฟล์ภาพเข้ามา
            $image = $request->file('file');

            //เช็คว่าผู้ใช้มีการอัพโหลดภาพเข้ามา
            if (!empty($image))
            {
                //อัพโหลดรูปภาพ
                //ตั้งชื่อรูป
                $file_name = "product_" . time() . "." . $image->getClientOriginalExtension();

                //กำหนดขนาดความกว้างและสูงของภาพ
                $imgWidth     = 400;
                $imgHeigh     = 400;
                $folderupload = public_path('/images/products/thumbnail');
                $path         = $folderupload . "/" . $file_name;

                //อัพโหลดเข้าสู่ folder thumbnail
                $img = Image::make($image->getRealPath());
                $img->orientate()->fit($imgWidth, $imgHeigh, function ($constraint)
                {
                    $constraint->upsize();
                });
                $img->save($path);

                //อัพโหลดภาพต้นฉบับเข้า folder original
                $destinationPath = public_path('/images/products/original');
                $image->move($destinationPath, $file_name);

                //กำหนด path รูปเพื่อใส่ในตารางในฐานข้อมูล
                $data_product['image'] = url('/') . '/images/products/thumbnail/' . $file_name;

            }
            else
            {
                $data_product['image'] = url('/') . '/images/products/thumbnail/no_img.jpg';
            }

            // return response($data_product, 201);

            // $product = Product::create($request->all());
            $products = Product::create($data_product);

            return response($products, 200);
            // return response($request->all(), 201);
        }
        else
        {
            return [
                'status' => 'permission denied to create',
            ];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // เช็คสิทธิ์ (role) ว่าเป็น admin (1)
        $user = auth()->user();

        if ($user->tokenCan("1"))
        {

            $request->validate([
                'name'  => 'required',
                'slug'  => 'required',
                'price' => 'required',
            ]);

            $data_product = array(
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'slug'        => $request->input('slug'),
                'price'       => $request->input('price'),
                'user_id'     => $user->id,
            );

            // รับภาพเข้ามา
            $image = $request->file('file');

            if (!empty($image))
            {

                $file_name = "product_" . time() . "." . $image->getClientOriginalExtension();

                $imgwidth     = 400;
                $imgHeight    = 400;
                $folderupload = public_path('/images/products/thumbnail');
                $path         = $folderupload . '/' . $file_name;

                // uploade to folder thumbnail
                $img = Image::make($image->getRealPath());
                $img->orientate()->fit($imgwidth, $imgHeight, function ($constraint)
                {
                    $constraint->upsize();
                });
                $img->save($path);

                // uploade to folder original
                $destinationPath = public_path('/images/products/original');
                $image->move($destinationPath, $file_name);

                $data_product['image'] = url('/') . '/images/products/thumbnail/' . $file_name;

            }

            $product = Product::find($id);
            $product->update($data_product);

            return $product;

        }
        else
        {
            return [
                'status' => 'Permission denied to create',
            ];
        }
        // return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = auth()->user();

        if($user->tokenCan('1')){
            return Product::destroy($id);
        }else{
            return [
                'status' => 'Permission denied to delete'
            ];
        }
    }

    public function search($keyword){
        return Product::with('users')
                    ->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orderBy('id', 'desc')
                    ->paginate(50);   
    }
}
