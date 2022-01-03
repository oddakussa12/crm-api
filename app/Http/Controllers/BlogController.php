<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
   
    public function index()
    {
        // return "hi check middle ware";
        $blogs = Blog::all();
        foreach($blogs as $blog){
            $blog->path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
        }
        return $blogs;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $image = $request->file('file');
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()]);
            }

            $name = rand().'.'.$image->getClientOriginalName();
            // $image->move(public_path('/uploads'),$name);
            $image->storeAs('public/',$name);
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->file = $name;
            $blog->description = $request->description;
            if($request->category_id){
                $blog->category_id = $request->category_id;
            }
            if($request->subcategory_id){
                $blog->subcategory_id = $request->subcategory_id;
            }
            $blog->save();

            if ($blog->exists) {
                return response()->json(['success' => 'Blog created successfuly'], 200);
            } else {
                return response()->json(['error' => 'Error'], 422);
            }
            
        }else{
            return response()->json('Please choose a file');
        }
    }

   
    public function show($id)
    {
        $blog = Blog::where('id',$id)->first();
        if($blog != null){
            $blog->path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
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
        // return $request;
        $image = $request->file('file');
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()]);
            }

            $name = rand().'.'.$image->getClientOriginalName();
            $image->storeAs('public/',$name);
            $blog = Blog::where('id',$id)->first();
            $blog->title = $request->title;
            $blog->file = $name;
            $blog->description = $request->description;
             if($request->category_id){
                $blog->category_id = $request->category_id;
            }
            if($request->subcategory_id){
                $blog->subcategory_id = $request->subcategory_id;
            }
            $blog->save();

            if ($blog->exists) {
                return response()->json(['success' => 'Blog updated successfuly'], 200);
            } else {
                return response()->json(['error' => 'Error'], 422);
            }
            
        }else{
            return response()->json('Please choose a file');
        }
        
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required',
        //     'file' => 'required',
        //     'description' => 'required',
        // ]);
        // if($validator->fails()){
        //     return response()->json(['errors'=>$validator->errors()]);
        // }

        // $blog = Blog::where('id',$id)->first();
        // if($blog){
        //     $blog->update($request->all()); 
        //     return response()->json(['success' => 'Blog updated successfuly'], 200);
        // }else{
        //     return response()->json(['error' => 'Update unsuccessful, Blog not found'], 404);
        // }  
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
