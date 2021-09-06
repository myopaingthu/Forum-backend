<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *  
     * @param  \App\Models\Reply $reply
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reply $reply)
    {
        $reply->likes()->create(['user_id' => auth()->id()]);

        return success('Like created successfully', null);
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply $reply
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->likes()->where('user_id', auth()->id())->first()->delete();
        
        return success('Like deleted successfully', null);
    }
}
