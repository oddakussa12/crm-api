<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
   
    public function index()
    {
        $blogs = Blog::all();
        return $blogs;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $blog = Blog::create($request->all());
        if ($blog->exists) {
            return response()->json(['success' => 'Blog created successfuly'], 200);
         } else {
            return response()->json(['error' => 'Error'], 422);
         }
    }

   
    public function show($id)
    {
        $blog = Blog::where('id',$id)->get();
        if(!$blog->isEmpty()){
            return $blog;
        }else{
            return response()->json(['error' => 'Blog not found'], 404);
        }
    }

    public function edit(Blog $blog)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $blog = Blog::where('id',$id)->first();
        if($blog){
            $blog->update($request->all()); 
            return response()->json(['success' => 'Blog updated successfuly'], 200);
        }else{
            return response()->json(['error' => 'Update unsuccessful, Blog not found'], 404);
        }  
    }

  
    public function destroy($id)
    {
        $blog = Blog::where('id',$id)->first();
        if($blog){
            $blog->delete();
            return response()->json(['success' => 'Blog deleted successfuly'], 200);
        }else{
            return response()->json(['error' => 'Delete unsuccessful, Blog not found'], 404);
        }
    }
}
