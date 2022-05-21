<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $todos = Todo::whereUserId($user->id)->latest()->get();
        return response()->json(['todos' => $todos], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validate = Validator::make($request->all(), [
            'title' => "required|string",
            "description" => "required|string",
        ]);
        if($validate->fails()){
            return response()->json(["message" => "Please fill in all required data"], 422);
        }
        $todo = Todo::create([
            'title' => $request->title,
            'user_id' => $user->id,
            'category' => $request->category,
            'status' => $request->status,
            'description' => $request->description,
            "others" => json_encode($request->others)
        ]);
        return response()->json([
            "message" => "created successfully",
            "data" => $todo
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $user = Auth::user();
        $todo = Todo::whereUserId($user->id)->whereId($todo)->first();
        if(!$todo){
            return response()->json(["message" => "unable to delete"]);
        }
        $todo->delete();
        return response()->json(['message' => "todo deleted successfully"]);
    }
}
