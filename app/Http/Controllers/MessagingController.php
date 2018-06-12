<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageReplyRequest;
use Illuminate\Pagination\Paginator;
use Event;
use App\Events\MessagingEvent;
use Session;
use DB;
use App\Message;
use App\MessageReply;
use Auth;
use App\User;
use App\Freelancer;
use App\proposal;
use App\ShortList;

class MessagingController extends Controller
{
    //Constructor

    public function __construct()
    {

    	$this->middleware(['auth']);
    }

    public function createMessage($id)

    {
        $user = proposal::where('id',$id)->first();
        $user = Freelancer::where('id',$user->freelancer_id)->first()->user_id;
        $freelancer = User::where('id',$user)->first();

    	return view('messages.create',array('title'=>'Send a Mesage','proposal_id'=>$id,'freelancer'=>$freelancer));

    }

    public function storeMessage(MessageRequest $request)

    {

    	$freelancer = $request->input('freelancer');
        $freelancer =json_decode($freelancer);
        $_message_already_sent = Message::where('user_id',Auth::User()->id)->where('receiver_id',$freelancer->id)->where('proposal_id',$request->input('proposal_id'))->where('message',$request->input('message'))->first();
        if($_message_already_sent)
        {
            $error = 'You had already sent this message to '.ucfirst($freelancer->name).' . Create a new message.';
            return Redirect::back()->withErrors($error);
        }
        $message = new Message;
        $message->user_id = Auth::User()->id;
        $message->receiver_id = $freelancer->id;
        $message->proposal_id = $request->input('proposal_id');
        $message->message = $request->input('message');
        $message->save();
        //start message session
        Session::put('msg',$message->message);

    	Event::Fire(new MessagingEvent($message->id,$freelancer));

        $proposal = Proposal::where('id',$message->proposal_id)->first();
        $already_shortlisted = ShortList::where('job_id',$proposal->job_id)->where('freelancer_id',$proposal->freelancer_id)->where('proposal_id',$proposal->id)->first();
        if(!$proposal)
        {
            return Redirect::route('add_to_shortlist',$message->proposal_id);
        }

    	return Redirect::back()->with('message','Message Sent');
    }

    public function createMessageReply($id)
    {
    	$message = Message::findOrFail($id);
    	return view('messages.replies.create',array('title'=>'Post a Reply','message'=>$message));
    }


    public function storeMessageReply(MessageReplyRequest $request)

    {
    	$input = $request->all();
    	$create = MessageReply::create($input);
         //start message session
        Session::put('msg',$request->input('message_reply'));

        $freelancer = User::where('id',Auth::User()->id)->first();

        Event::Fire(new MessagingEvent($request->input('message_id'),$freelancer));

    	return Redirect::back()->with('message','Reply Sent');
    }


      public function showMessages()
    {

        return view('messages.showMessages',['title'=>'Messages']);
    }

    public function sentMessages()
    {

        $messages = Message::with('replies')->where('user_id',Auth::User()->id)->paginate(15);

        return view('messages.sendMessages',['title'=>'Messages Sent','messages'=>$messages]);
    }

    public function messageChat($id)
    {
        $messages = Message::with('replies')
        ->where('id',$id)
        ->get();
        $replies = DB::table('message_replies')
                    ->join('users','user_id','users.id','message_replies.user_id')
                    ->orderBy('message_replies.created_at','asc')
                    ->where('message_id',$id)->get();
                   

        return view('messages.messageChat',['messages'=>$messages,'replies'=>$replies]);
    }

     public function inbox()
    {
       //$messages = Message::where('receiver_id',Auth::User()->id)->get();
       $messages = DB::table('messages')                
                    ->join('users','user_id','users.id','messages.user_id')
                    ->join('proposals','proposal_id','proposals.id','messages.proposal_id')
                    ->join('jobs','proposals.job_id','jobs.id','proposals.job_id')
                    ->where('messages.receiver_id',Auth::User()->id)
                    ->orderBy('messages.created_at','desc')
                    ->paginate(15);
        $replies = DB::table('message_replies')
                    ->join('messages','message_id','messages.id','message_replies.message_id')
                    ->join('users','message_replies.user_id','users.id','messages_replies.user_id')
                    ->join('proposals','proposal_id','proposals.id','messages.proposal_id')
                    ->join('jobs','proposals.job_id','jobs.id','proposals.job_id')
                    ->where('message_replies.user_id','!=',Auth::User()->id)
                     ->orderBy('message_replies.created_at','desc')
                    ->paginate(15);


        return view('messages.inbox',['messages'=>$messages,'title'=>'Inbox','replies'=>$replies]);
    }

    public function deleteMessge($id)

    { 
    	$message = findOrFail($id);
    	$message->delete();
    	return 'Message deleted';

    }

    public function deleteMessgeReply($id)

    { 
    	$reply = findOrFail($id);
    	$reply->delete();
    	return 'Message reply deleted';

    }
}
