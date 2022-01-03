<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Catetory;
use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class SubcategoryController extends Controller
{
  
    public function index()
    {
        $subcategory = Subcategory::all();
        return $subcategory;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        // check if category exist for the given category
        $category = Catetory::where('id',$request->category_id)->get();
        if(!$category->isEmpty()){
            $subcategory = Subcategory::create($request->all());
            if ($subcategory->exists) {
                return response()->json(['success' => 'Subategory created successfuly'], 200);
             } else {
                return response()->json(['error' => 'Error'], 422);
             }
        }else{
            return response()->json(['error' => 'Category not found'], 422);
        }
    }

    public function show($id)
    {
        $subcategory = Subcategory::where('id',$id)->get();
        if(!$subcategory->isEmpty()){
            return $subcategory;
        }else{
            return response()->json(['error' => 'Subcategory not found'], 404);
        }
    }

    public function edit(Subcategory $subcategory)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        // check if category exist for the given category
        $category = Catetory::where('id',$request->category_id)->get();
        if(!$category->isEmpty()){
            $subcategory = Subcategory::where('id',$id)->first();
            if($subcategory){
                $subcategory->update($request->all()); 
                return response()->json(['success' => 'Subcategory updated successfuly'], 200);
            }else{
                return response()->json(['error' => 'Update unsuccessful, Subcategory not found'], 404);
            }
        }else{
            return response()->json(['error' => 'Update unsuccessful, Category not found'], 404);
        }
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::where('id',$id)->first();
        if($subcategory){
            $subcategory->delete();
            return response()->json(['success' => 'Subcategory deleted successfuly'], 200);
        }else{
            return response()->json(['error' => 'Delete unsuccessful, Subcategory not found'], 404);
        }
    }
    public function subcategoryBlogs($subcategoryId){
        $blogs = Blog::where('subcategory_id',$subcategoryId)->get();
        if(!$blogs->isEmpty()){
            foreach($blogs as $blog){
                $blog->file_path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
                $blog->thumbnail_path = 'https://blogpost.yenesera.com/storage/'.$blog->thumbnail;
            }
            return $blogs;
        }else{
            return response()->json(['error' => 'No blog found in this Subcategory'], 404);
        }

    }
}
