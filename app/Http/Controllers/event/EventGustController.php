<?php

namespace App\Http\Controllers\event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventGustController extends Controller
{
    public function index():view
    {
        $events = Event::where('status',1)->get();
        return view('event.event_guest_record',compact('events'));
    }

    public function eventGuestRecords(Request $request): array
    {
        $draw = $request->post('draw');
        $start = $request->post("start");
        $rowperpage = $request->post("length"); // Rows display per page

        $columnIndex_arr = $request->post('order');
        $columnName_arr = $request->post('columns');
        $order_arr = $request->post('order');
        $search_arr = $request->post('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = EventGuest::count('id');

        $query = DB::table('event_guests as a')
                    ->join('events as b', 'b.id', '=', 'a.event_id')
                    ->where(function($query) use ($searchValue){
                        $query->where('a.id', 'LIKE', '%'.$searchValue.'%')
                            ->orWhere('a.guest_email', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('a.guest_name', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('b.reminder_id', 'LIKE', '%'.$searchValue.'%');
                    });

        $searchData = $request->searchData;
        $status     = $request->status;

        if (isset($status)) {
            $query = $query->where('a.active', $status);
        }

        if (isset($searchData)) {
            $query = $query->where(function ($query) use ($searchData) {
                $query->where('a.id', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.guest_email', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.guest_name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('b.reminder_id', 'LIKE', '%' . $searchData . '%');
            });
        }

        $totalRecordswithFilter = $query->count('a.id');

        // Fetch records
        $records = $query->select('a.id',
                                        'b.reminder_id',
                                        'a.guest_email',
                                        'a.guest_name',
                                        'a.event_id',
                                        'a.status')
                            ->orderBy($columnName,$columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data = [];

        foreach($records as $row){
            $id = $row->id;
            $button = '<a href="javascript:deleteData('.$id.');" type="button" class="btn btn-danger btn-sm" title="Delete Data"><i class="fas fa-trash"></i></a> ';
            $button .= '<a href="'.route('event.guest.reminder.send',$id).'" type="button" class="btn btn-info btn-sm" title="Send Email"><i class="fas fa-paper-plane"></i></a> ';

            if($row->status == 1){
                $status = '<span class="badge badge-success">Active</span>';
            }else{
                $status = '<span class="badge badge-danger">In-Active</span>';
            }

            $data[] = [
                'id'          => $row->id,
                'reminder_id' => $row->reminder_id,
                'guest_email' => $row->guest_email,
                'guest_name'  => $row->guest_name,
                'status'      => $status,
                'action'      => $button
            ];
        }

        $response = [
            "draw"              => $draw,
            "recordsTotal"      => $totalRecords,
            "recordsFiltered"   => $totalRecordswithFilter,
            "data"              => $data
        ];

        return $response;
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'guest_email' => 'required',
            'guest_name'  => 'required',
            'event_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with('warning', 'Invalid Data');
        }

        $count = EventGuest::where([['guest_email',$request->guest_email],['event_id',$request->event_id]])->get()->count();

        if ($count > 0) {
            return Redirect::back()->withErrors($validator)->withInput()->with('warning', 'This Email Already Registered For This Event');
        }

        try {
            DB::beginTransaction();
            EventGuest::create([
                'guest_email' => $request->guest_email,
                'guest_name'  => $request->guest_name,
                'event_id'    => $request->event_id,
                'status'      => 1,
            ]);

            DB::commit();
            return Redirect::route('event.guest.record')->with('message', 'Successfully  Added');
        } catch (\Exception $exception) {
            DB::rollback();
            //dd($exception->getMessage());
            //return Redirect::back()->with('error',$exception->getMessage());
            return Redirect::back()->withInput()->with('error', 'Failed to save');
        }
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
        ]);

        if ($validator->fails()) {
            return ['msg' => 'Please check the information on the form and correct them', 'v_error' => $validator->errors()];
        }
        try {
            DB::beginTransaction();
            $id = $request->post('id');
            EventGuest::where('id', $id)->delete();

            DB::commit();
            return ['success' => 'Data delete successfully!'];
        }catch (\Exception $exception){
            DB::rollback();
            return ['error' => 'Data delete failed', 'v_error' => $exception->getMessage()];
        }
    }
}
