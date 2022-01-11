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
        $blogs = Blog::paginate(5);
        // foreach($blogs as $blog){
        //     $blog->file_path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
        //     $blog->thumbnail_path = 'https://blogpost.yenesera.com/storage/'.$blog->thumbnail;
        // }
        return $blogs;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'body'   => 'required',
            'author' => 'required',
            'date'   => 'required|date_format:Y-m-d H:i:s',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->author = $request->author;
        $blog->date = $request->date;
        $blog->save();

        if ($blog->exists) {
            return $blog;
        } else {
            return response()->json(['error' => 'Error'], 422);
        }
    }

    // public function store(Request $request)
    // {
    //     $image = $request->file('file');
    //     $image2 = $request->file('thumbnail');
    //     if($request->hasFile('file') && $request->hasFile('thumbnail')){
    //         $validator = Validator::make($request->all(), [
    //             'title'         => 'required',
    //             'description'   => 'required',
    //             'thumbnail'     => 'mimes:jpeg,jpg,png,gif|required|max:10000', //kb
    //         ]);
    //         if($validator->fails()){
    //             return response()->json(['errors'=>$validator->errors()]);
    //         }

    //         $name = rand().'.'.$image->getClientOriginalName();
    //         $name2 = rand().'.'.$image2->getClientOriginalName();
    //         // $image->move(public_path('/uploads'),$name);
    //         $image->storeAs('public/',$name);
    //         $image2->storeAs('public/',$name2);

    //         $blog = new Blog();
    //         $blog->title = $request->title;
    //         $blog->file = $name;
    //         $blog->thumbnail = $name2;
    //         $blog->description = $request->description;
    //         if($request->category_id){
    //             $blog->category_id = $request->category_id;
    //         }
    //         if($request->subcategory_id){
    //             $blog->subcategory_id = $request->subcategory_id;
    //         }
    //         $blog->save();

    //         if ($blog->exists) {
    //             return response()->json(['success' => 'Blog created successfuly'], 200);
    //         } else {
    //             return response()->json(['error' => 'Error'], 422);
    //         }
            
    //     }else{
    //         return response()->json('Please choose a file');
    //     }
    // }

   
    public function show($id)
    {
        $blog = Blog::where('id',$id)->first();
        if($blog != null){
            // $blog->file_path = 'https://blogpost.yenesera.com/storage/'.$blog->file;
            // $blog->thumbnail_path = 'https://blogpost.yenesera.com/storage/'.$blog->thumbnail;
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
            'title'  => 'required',
            'body'   => 'required',
            'author' => 'required',
            'date'   => 'date_format:Y-m-d H:i:s',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $blog = Blog::where('id',$id)->first();

        if ($blog) {
            $blog->title = $request->title;
            $blog->body = $request->body;
            $blog->author = $request->author;
            $blog->date = $request->date;
            $blog->save();
            if($blog->exists){
                return $blog;
            }else{
                return response()->json(['error' => 'Operation unsuccessful'],422);
            }
            
        } else {
            return response()->json(['error' => 'Blog with the given id not found'], 422);
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
