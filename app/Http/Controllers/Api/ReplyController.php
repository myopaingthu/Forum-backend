<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $replies = $question->replies;

        return ReplyResource::collection($replies)->additional(['result' => 1, 'message' => 'Retrieved.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Question $question
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $request->validate(['body' => 'required']);

        $reply = $question->replies()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return success('Reply created successfully', null); 
    }

    /**
     * Display the specified resource.
     *  
     * @param \App\Models\Question $question
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        return success('Retrieved', new ReplyResource($reply));
    }

    /**
     * Update the specified resource in storage.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $request->validate(['body' => 'required']);

        $reply->update($request->all());

        return success('Reply edited successfully', null); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->delete();

        return success('Reply deleted successfully', null);
    }
}
