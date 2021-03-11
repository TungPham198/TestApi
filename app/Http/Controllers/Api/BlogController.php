<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Blog;

class BlogController extends Controller
{
    protected $rules = [
        'name'=>'required|min:0|max:100',
        'des'=>'required|min:0|max:1000',
    ];

    protected $errors = [
        'name.required'=>'Không để trống tên',
        'des.required'=>'Không để trống nội dung',
        'name.min'=>'Tên từ 0 đến 100 kí tự',
        'name.max'=>'Tên từ 0 đến 100 ký tự',
        'des.min'=>'Nội dung từ 0 đến 100 kí tự',
        'des.max'=>'Nội dung từ 0 đến 100 ký tự',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::orderBy('id','desc')->get();

        return response()->json([
            'status'=>'success',
            'content'=>'thanh cong',
            'data'=>$blog
        ]);
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
        $validator = Validator::make($request->all(),$this->rules,$this->errors);
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'content'=>'that bai',
                'data'=>$validator->errors()->all()
            ]);
        }
        $blog = Blog::insert([
            'name'=>$request->name,
            'des'=>$request->des
        ]);
        if($blog){
            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>'Thêm thành công' 
            ]);
        }
        return response()->json([
            'status'=>'error',
            'content'=>'that bai',
            'data'=>'Thêm thất bại, vui lòng thử lại sau' 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if($blog){
            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>$blog
            ]);
        }
        return response()->json([
            'status'=>'error',
            'content'=>'that bai',
            'data'=>'Không có dữ liệu trả về' 
        ]);
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
        $validator = Validator::make($request->all(),$this->rules,$this->errors);
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'content'=>'that bai',
                'data'=>$validator->errors()->all()
            ]);
        }
        $blog = Blog::find($id);
        if($blog){
            $blog->name=$request->name;
            $blog->des=$request->des;
            $check = $blog->save();
            if($check){
                return response()->json([
                    'status'=>'success',
                    'content'=>'thanh cong',
                    'data'=>'Cập nhật  thành công' 
                ]);
            }
        }else{
            return response()->json([
                'status'=>'error',
                'content'=>'that bai',
                'data'=>'Cập nhật thất bại, vui lòng thử lại sau' 
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $check=false;
        if($blog){
            $check = $blog->delete();
        }
        if($check){
            return response()->json([
                'status'=>'success',
                'content'=>'thanh cong',
                'data'=>'Xoá thành công' 
            ]);
        }
        return response()->json([
            'status'=>'error',
            'content'=>'that bai',
            'data'=>'Xoá thất bại, vui lòng thử lại sau' 
        ]);
    }
}
