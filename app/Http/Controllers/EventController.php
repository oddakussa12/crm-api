<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Validator;

class EventController extends Controller
{
   
    public function index()
    {
        $events = Event::orderByDesc('created_at')->paginate(5);
        foreach($events as $event){
            $event->cover_image = 'http://localhost:8000/storage/'.$event->cover_image;
        }
        return $events;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $image = $request->file('cover_image');
        if($request->hasFile('cover_image')){
            $validator = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'required',
                'cover_image'     => 'mimes:jpeg,jpg,png,gif|required|max:10000', //kb
                'start_date'         => 'required|date_format:Y-m-d H:i:s',
                'end_date'   => 'required|date_format:Y-m-d H:i:s',
                'is_public'     => 'required|boolean', 
                'is_limited'         => 'required|boolean',
                'available_spots'   => 'required|integer|min:5',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()]);
            }

            $name = rand().'.'.$image->getClientOriginalName();
            // $image->move(public_path('/uploads'),$name);
            $image->storeAs('public/',$name);

            $event = new Event();

            $event->cover_image = $name;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->is_limited = $request->is_limited;
            $event->is_public = $request->is_public;
            $event->available_spots = $request->available_spots;
            $event->is_archived = 0;
            $event->save();

            if ($event->exists) {
                // return response()->json(['success' => 'Event created successfuly'], 200);
                return redirect()->action(
                    [EventController::class, 'index']
                );
            } else {
                return response()->json(['error' => 'Error'], 422);
            }
            
        }else{
            return response()->json('Please choose a cover image for this event');
        }
    }

    public function show($id)
    {
        $event = Event::where('id',$id)->first();
        if($event != null){
            $event->cover_image = 'http://localhost:8000/storage/'.$event->cover_image;
            // $blog->thumbnail_path = 'https://blogpost.yenesera.com/storage/'.$blog->thumbnail;
            return $event;
        }else{
            return response()->json(['error' => 'Blog not found'], 404);
        }
    }

    public function edit(Event $event)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $image = $request->file('cover_image');
        if($request->hasFile('cover_image')){
            $validator = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'required',
                'cover_image'     => 'mimes:jpeg,jpg,png,gif|required|max:10000', //kb
                'start_date'         => 'required|date_format:Y-m-d H:i:s',
                'end_date'   => 'required|date_format:Y-m-d H:i:s',
                'is_public'     => 'required|boolean', 
                'is_limited'         => 'required|boolean',
                'is_archived'   => 'boolean',
                'available_spots'   => 'required|integer|min:5',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()]);
            }

            $name = rand().'.'.$image->getClientOriginalName();
            // $image->move(public_path('/uploads'),$name);
            $image->storeAs('public/',$name);

            $event = Event::where('id',$id)->first();

            if($event){
                $event->cover_image = $name;
                $event->title = $request->title;
                $event->description = $request->description;
                $event->start_date = $request->start_date;
                $event->end_date = $request->end_date;
                $event->is_limited = $request->is_limited;
                $event->is_public = $request->is_public;
                $event->available_spots = $request->available_spots;
                if($request->is_archived){
                    $event->is_archived = $request->is_archived;
                }else{
                    $event->is_archived = 0;
                    // $event->is_archived = $event->is_archived;
                }
                $event->save();
    
                if ($event->exists) {
                    // return response()->json(['success' => 'Event created successfuly'], 200);
                    return redirect()->action(
                        [EventController::class, 'index']
                    );
                } else {
                    return response()->json(['error' => 'Error'], 422);
                }
            }else{
                return response()->json(['Message' => 'Event with the given id is not found'], 422);
            }
            
        }else{
            return response()->json('Please choose a cover image for this event');
        }
    }

    public function destroy($id)
    {
        $event = Event::where('id',$id)->first();
        if($event){
            $event->delete();
            return response()->json(['success' => 'Event deleted successfuly'], 200);
        }else{
            return response()->json(['error' => 'Delete unsuccessful, Event not found'], 404);
        }
    }
    public function archive($id)
    {
        $event = Event::where('id',$id)->first();
        if($event){
            if($event->is_archived == 0){
                $event->is_archived = 1;
                $event->save();
                return $event;
            }else{
                return response()->json(['error' => 'Event is already archived']);   
            }
        }else{
            return response()->json(['error' => 'Archival unsuccessful, Event not found'], 404);
        }
    }
}
