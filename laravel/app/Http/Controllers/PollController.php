<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Poll;
use App\Models\Vote;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    /**
     * Store the specified data in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = auth()->user()->role;
        if ($role !== 'admin') {
            return response()->json(["message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required | date_format:Y-m-d H:i:s',
            'choices' => 'required | array | min:2',
            'choices.*' => 'required | string | distinct'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'The given data was invalid'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $request->deadline);

        // Model Poll
        $polls = new Poll();
        $polls->title = $request->title;
        $polls->description = $request->description;
        $polls->datetime = $date;
        $polls->created_by = auth()->user()->username;
        $polls->save();

        $polls_id = $polls->id;
        $choices = $request->choices;

        foreach ($choices as $single) {
            $choice = new Choice();
            $choice->choice = $single;
            $choice->poll_id = $polls_id;
            $choice->save();
        }

        return response()->json(compact('polls'), Response::HTTP_OK);
    }

    /**
     * Show all Poll data from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($poll_id)
    {
        $user = auth()->user();
        $poll = Poll::findOrFail($poll_id);
        $today = Carbon::now();

        $vote = Vote::where([
            'user_id' => $user->id,
            'poll_id' => $poll->id
        ])->get();

        if (($user->role == 'admin' && $poll->user_id == $user->id) || $poll->deadline <= $today || isset($vote->id)) {
            return response()->json(['poll' => $poll, 'creator' => $user->username], Response::HTTP_OK);
        }
    }


    /**
     * Show all Poll data from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        $user = auth()->user();
        $polls = Poll::all();
        $choice = Choice::all();

        $arr = [];

        if ($user->role === 'admin') {
            $arr = $polls;
            return response()->json($arr);
        }

        if ($user->role === 'user') {
            foreach ($polls as $poll) {
                $vote = Vote::where([
                    'user_id' => $user->id,
                    'poll_id' => $poll->id
                ])->get();

                $arr = $vote;
                return response()->json($arr);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = Poll::findOrFail($id);
        $poll->delete();

        return response()->json(['message' => 'poll deleted'], 200);
    }
}
