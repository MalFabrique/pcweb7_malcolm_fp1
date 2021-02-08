<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Meeting;
use App\Models\User;
use App\Models\Profile;

class CalendarController extends Controller
{
    //
    

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $profile = Profile::find($user_id);

        return view('calendar');
  

    }


    public function get_meetings()
    {
        
        $all_meetings = \App\Models\Meeting::all();
        
        $data = [];
        foreach($all_meetings as $meeting)
         {
            $data[] = array(
                'id'  => $meeting['id'],
                'title'  => $meeting['title'], 
                'start'  => $meeting['start_date'],
                'end'  => $meeting['end_date']
            );
        }       

        return $data;

    }


    public function create_meeting(Request $request){

 
        $user = Auth::user();
        $meeting = new \App\Models\Meeting();
 
        $meeting->user_id = $user->id; 

        $meeting->title = $request->title; 
        $meeting->start_date = $request->start; 
        $meeting->end_date = $request->end; 
        $saved = $meeting->save();
 
        
        if ($saved) {
            return 'saved';
        }
    }
 



    public function update_meeting(Request $request){

        $id = $request->id ; 
        $user = Auth::user();
        $meeting = \App\Models\Meeting::find($id);
 
        $meeting->user_id = $user->id; 

        $meeting->title = $request->title; 
        $meeting->start_date = $request->start; 
        $meeting->end_date = $request->end; 
        $saved = $meeting->save();
 
        
        if ($saved) {
            return 'Updated';
        }
    }



    public function delete_meeting(Request $request){

        $id = $request->id ; 
        $id = (int)$id;
        $meeting =  \App\Models\Meeting::find($id);

        $action = $meeting->delete();

        if($action){
            return 'Meeting Deleted';
        }        

       

    }

    
}




