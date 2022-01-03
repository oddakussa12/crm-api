<?php

namespace App\Http\Controllers;

use App\Models\Catetory;
use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class CatetoryController extends Controller
{
   
    public function index()
    {
        $category = Catetory::all();
        return $category;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
    
        $category = Catetory::create($request->all());
        if ($category->exists) {
            return response()->json(['success' => 'Category created successfuly'], 200);
         } else {
            return response()->json(['error' => 'Error'], 422);
         }
    }

    public function show($id)
    {
        $category = Catetory::where('id',$id)->get();
        if(!$category->isEmpty()){
            return $category;
        }else{
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    public function edit(Catetory $catetory)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $category = Catetory::where('id',$id)->first();
        if($category){
            $category->update($request->all()); 
            return response()->json(['success' => 'Category updated successfuly'], 200);
        }else{
            return response()->json(['error' => 'Update unsuccessful, Category not found'], 404);
        }
    }

    public function destroy($id)
    {
        $category = Catetory::where('id',$id)->first();
        if($category){
            $category->delete();
            return response()->json(['success' => 'Category deleted successfuly'], 200);
        }else{
            return response()->json(['error' => 'Delete unsuccessful, Category not found'], 404);
        }
    }

    public function categoryBlogs($categoryId){
        $blogs = Blog::where('category_id',$categoryId)->get();
        if(!$blogs->isEmpty()){
            foreach($blogs as $blog){
                $blog->file_path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
                $blog->thumbnail_path = 'https://blogpost.yenesera.com/storage/'.$blog->thumbnail;
            }
            return $blogs;
        }else{
            return response()->json(['error' => 'No blog found in this category'], 404);
        }

    }
}
