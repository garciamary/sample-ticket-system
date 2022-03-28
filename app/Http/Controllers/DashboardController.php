<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;


class DashboardController extends Controller
{
    public function index(Request $request){
        // var_dump($request->user()->id);
        $searchbox = $request->query('searchbox');
        if($searchbox == ''){
            $tickets = Ticket::where('submitter_id', $request->user()->id)->get();
        }else{
            $tickets = Ticket::where('name','like','%'.$searchbox.'%')->where('submitter_id', $request->user()->id)->get();
        }
        return view('dashboard' , ['tickets'=>$tickets]);
    }



}
