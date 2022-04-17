<?php

namespace App\Http\Controllers;

// use Facade\FlareClient\Http\Response;

use App\Models\Choice;
use App\Models\Poll;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoteController extends Controller
{
    /**
     * Vote system.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vote($poll_id, $choice_id)
    {
        $user = auth()->user();
        $poll = Poll::findOrFail($poll_id);
        $choice = Choice::findOrFail($choice_id);

        $vote = new Vote();
        $today = Carbon::now();

        if ($user->role === 'admin') {
            return response()->json(['message' => 'admin cannot vote'], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $vote->choice_id = $choice->id;
            $vote->user_id = $user->id;
            $vote->poll_id = $poll->id;
            $vote->division_id = $user->id;
            $vote->save();
            return response()->json(['user_id' => [$user->id, $user->division_id]], Response::HTTP_OK);
        }

        if ($today > $poll->deadline || $today == $poll->deadline) {
            return response()->json(['message' => 'voting deadline'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validator = Vote::where([
            'poll_id' => $poll->id,
            'user_id' => $user->id
        ])->get()->first();

        if (isset($validator->id)) {
            return response()->json(['message' => 'already voted'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Point System.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function point()
    {
        // 
    }
}
