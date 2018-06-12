<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionCategory;
use App\Question;
use Validator;
use Illuminate\Support\Facades\Input;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //List questions

    public function index()
    {
        //$user = JWTAuth::authenticate();
        //return $user;
        $questions = DB::table('questions')
        ->join('question_categories','questions.category_id','questions.category_id','question_categories.id')
        ->join('question_tags','questions.id','question_tags.question_id','questions.id')
        ->orderBy('created_at','desc')
        ->get();

        if(empty($questions))
        {
            return 'No questions so far, be the first one to post';
        }

        return $questions;
    }


    //Create a question
    public function store(Request $request)
    {
        //Validate user input

         $rules = [
            'question'           => 'required|string|unique:questions',
          'category_id'           => 'required',
            'question_detail' =>'required|string',
            'tags'=>'required',
                ];

                $validator = Validator::make(Input::all(), $rules);

     // Return back to form w/ validation errors & session data as input

     if($validator->fails()) {
        return $validator->messages();

    }
        $question = new Question;
        $question->question = $request->question;
        $question->question_detail = $request->question_detail;
        $question->category_id = $request->category_id;
        $question->user_id =1;// Auth::getUser();
        $question->save();

        //Save each question with its tags
        $tags = $request->tags;
       for($i=0;$i<count($tags);$i++)
       {
        $tag = new QuestionTag;
        $tag->question_id = $question->id;
        $tag->tag_id =$tags[$i];
        $tag->save();
       }

        return 'Question Posted, wait for response from the community!';


    }

    public function show($id)
    {
        /*$question = DB::table('questions')
        ->join('question_categories','questions.category_id','questions.category_id','question_categories.id')
        ->join('question_tags','questions.id','question_tags.question_id','questions.id')
        ->where('questions.id',$id)
        ->first();*/
        $question = Question::with(['answers','tags'])->where('questions.id',$id)->first();

        return $question;
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $question = Question::findOrFail($id);
        $question->update($input);
        return $question;
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return 'Question removed by'.BackendAuth::getUser()->id;
    }

    //Fetch questions with answers
    public function questionsWithAnswers()
    {
        $questions = Question::with('answers')->get();
        return $questions;
    }

    //Vote on questions

    public function questionVote(Request $request, $id)
    {
        $alreadyVoted = QuestionVote::where('question_id',$id)
        ->where('user_id',3)->first();

        
        if($alreadyVoted)
        {
            return 'You already voted on this question';
        }
        $vote = new QuestionVote;
        $vote->question_id = $id;
        $vote->user_id = 7;
        $vote->vote = $request->vote;
        $vote->save();
        //Fire the event that will assign reputation points to the author of the question if the vote is an upvote
        $url = $request->url();
        Event::fire('QuestionVoteEvent', [$question=1, $vote=1, $voter=7, $url]);

        //Event::fire(QuestionVotedEvent($question=$vote->question_id,$vote=$vote->vote,$voter=3,$url));

        return 'Voting Successful';


    }
}
