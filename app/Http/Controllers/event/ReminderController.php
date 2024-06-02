<?php

namespace App\Http\Controllers\event;

use App\Http\Controllers\Controller;
use App\Mail\RemienderMail;
use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ReminderController extends Controller
{
    public function index(){
        try {
            DB::beginTransaction();
            $now = date('Y-m-d H:i:s');
            $hourAfter = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $event = Event::where('status',1)->whereBetween('event_date_time', [$now, $hourAfter])->get();
//            dd($now,$hourAfter, $event);

            foreach ($event as $event_row){
               $guest = EventGuest::where([['event_id', $event_row->id],['status',1]])->get();

               foreach ($guest as $guest_row){
                   $data = [
                       'guest_name'   => $guest_row->guest_name,
                       'guest_email'  => $guest_row->guest_email,
                       'event_name'   => $event_row->title,
                       'event_details'=> $event_row->details,
                       'reminder_id'  => $event_row->reminder_id,
                       'event_time'   => $event_row->event_date_time,
                   ];

                   $this->sendReminder($data);

                   EventGuest::where('id',$guest_row->id)->update(['status'=>1]);
               }
                Event::where('id',$event_row->id)->update(['status'=>2]);
            }


            DB::commit();
        }catch (\Exception $exception){
            DB::rollback();
            dd($exception->getMessage());
        }
    }

    public function staticMailSendReminder($id){
//        dd($id);
        try {
            $guest = EventGuest::where('id', $id)->with('event')->first();
            $data = [
                'guest_name'   => $guest->guest_name,
                'guest_email'  => $guest->guest_email,
                'event_name'   => $guest->event->title,
                'event_details'=> $guest->event->details,
                'reminder_id'  => $guest->event->reminder_id,
                'event_time'   => $guest->event->event_date_time,
            ];

            $this->sendReminder($data);

            return Redirect::route('event.guest.record')->with('message', 'Successfully Send');
        } catch (\Exception $exception) {
            DB::rollback();
            return Redirect::back()->with('error',$exception->getMessage());
//            return Redirect::back()->withInput()->with('error', 'Failed to Send');
        }
    }

    public function sendReminder($guest){

        Mail::to($guest['guest_email'])->send(New RemienderMail($guest));
    }
}
