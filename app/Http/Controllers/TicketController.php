<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Redirect;


class TicketController extends Controller
{

    public function index(Request $request){
     
        $searchbox = $request->query('searchbox');
        if($searchbox == ''){
            $tickets = Ticket::all();
        }else{
            $tickets = Ticket::where('name','like','%'.$searchbox.'%')->get();
        }
        return view('tickets.index', ['tickets' => $tickets]);
    }


    public function create(){
        $users = User::all();
        return view('tickets.create', ['users' => $users]);
    }
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        var_dump($request ->input());
        $name =  $request->input('name');
        $subject =  $request->input('subject');
        $label =  $request->input('label');
        $assignee_id =  $request->input('assignee_id');
        $submitter_id =  $request->user()->id;
        $priority =  $request->input('priority');
        $status =  $request->input('status');
        var_dump([$name,$subject,$label,$assignee_id, $submitter_id, $priority, $status]);

        $ticket = new Ticket;
        // $ticket->title = $request->title;
        $ticket->name = $name;
        $ticket->subject = $subject;
        $ticket->label = $label;
        $ticket->assignee_id = $assignee_id;
        $ticket->submitter_id = $submitter_id;
        $ticket->priority = $priority;
        $ticket->status = $status;
        $ticket->save();
      return Redirect::route('tickets.index');
        // $name = $request->input('name');
    }

    public function show($id, Request $request){
        $ticket = Ticket::where('id', $id)->with(['comments.user'])->first();
        $users = User::all();
        return view('tickets.show', ['ticket' => $ticket, 'users' => $users]);

    }

    public function update($id, Request $request){
        // var_dump($id);
        // var_dump($request ->input());
        $ticket = Ticket::find($id);
        $ticket->name = $request->input('name');
        $ticket->subject = $request->input('subject');
        $ticket->label = $request->input('label');
        if(Auth::user()->role == 'Admin') {
        $ticket->assignee_id = $request->input('assignee_id');
        $ticket->priority = $request->input('priority');
        $ticket->status = $request->input('status');
        }

        $ticket->save();
        // die;
        return Redirect::route('tickets.index');
    }


    public function destroy($id, Request $request){
        // var_dump($id);
        Ticket::destroy($id);
        // die;
        return Redirect::route('tickets.index');
    }

    public function apiGetAll(Request $request) {

            $tickets = Ticket::all();
            if($request->user()->role == 'Admin'){
                $tickets = Ticket::with(['assignee', 'submitter'])->get();
                return response()->json($tickets, 200);
            }else {
                $tickets = Ticket::where('submitter_id', $request->user()->id)->orWhere('assignee_id', $request->user()->id)->get();
                return response()->json($tickets, 200);
            }


    }


    public function apiGetOne($id){

        try {

            $tickets = Ticket::where('id',$id)->firstOrFail();

        } catch (\Throwable $th) {

            return response()->json('Ticket Not Found',404);

        }

        return response()->json($tickets ,200);
    }

    public function apiCreateTicket (Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required | max:100',
            'subject' => 'required | max:100',
            'label' => 'required | max:100',
            'assignee_id' => 'required | exists:tickets,assignee_id',
            'submitter_id' => 'required | exists:tickets,submitter_id',
            'priority' => 'required | in:Low,Mid,High',
            'status' => 'required | in:Resolved,On-going,Rejected',
        ]);


        $data = $request->only([
            'name',
            'subject',
            'label',
            'assignee_id',
            'submitter_id',
            'priority',
            'status'
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 400);
        }


        $tickets = Ticket::create($data);

        if($tickets) {

            return response()->json('Ticket Created', 200);

        } else {

            return response()->json('Unable to create ticket', 400);
        }

        return response()->json('',200);

    }


    public function apiUpdateTicket($id, Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required | max:100',
            'subject' => 'required | max:100',
            'label' => 'required | max:100',
            'assignee_id' => 'required | exists:tickets,assignee_id',
            'submitter_id' => 'required | exists:tickets,submitter_id',
            'priority' => 'required | in:Low,Mid,High',
            'status' => 'required | in:Resolved,On-going,Rejected',
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 400);
        }

        try {

            $data = $request->only([
                'name',
                'subject',
                'label',
                'assignee_id',
                'submitter_id',
                'priority',
                'status'
            ]);

            Ticket::find($id)->update($data);

            return response()->json($data, 200);

        } catch (\Throwable $th) {

            return response()->json('Ticket not created', 404);

        }
    }

    public function apiDestroy($id, Request $request) {

        $tickets = Ticket::all();

        Ticket::destroy($id);

        return response()->json('Ticket deleted', 400);
    }


}
