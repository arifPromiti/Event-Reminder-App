<?php

namespace App\Http\Controllers\event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('event.event_record');
    }

    public function addEvent(): View
    {
        return view('event.event_add');
    }

    public function editEvent($id): View
    {
        $data = $this->eventData($id);
        return view('event.event_edit',compact('data'));
    }

    public function eventRecords(Request $request): array
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
        $totalRecords = Event::count('id');

        $query = DB::table('events as a')
                    ->where(function($query) use ($searchValue){
                        $query->where('a.id', 'LIKE', '%'.$searchValue.'%')
                            ->orWhere('a.reminder_id', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('a.title', 'LIKE', '%'.$searchValue.'%');
                    });

        $searchData = $request->searchData;
        $status     = $request->status;

        if (isset($status)) {
            $query = $query->where('a.active', $status);
        }

        if (isset($searchData)) {
            $query = $query->where(function ($query) use ($searchData) {
                $query->where('a.id', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.reminder_id', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.title', 'LIKE', '%' . $searchData . '%');
            });
        }

        $totalRecordswithFilter = $query->count('a.id');

        // Fetch records
        $records = $query->select('a.id',
                                        'a.reminder_id',
                                        'a.title',
                                        'a.event_date_time',
                                        'a.status')
                                        ->orderBy($columnName,$columnSortOrder)
                                        ->skip($start)
                                        ->take($rowperpage)
                                        ->get();

        $data = [];

        foreach($records as $row){
            $id = $row->id;

            $button = '<a href="'.route('event.edit',$id).'" type="button" class="btn btn-warning btn-sm" title="Edit Data"><i class="fas fa-edit"></i></a> ';
            $button .= '<a href="javascript:deleteData('.$id.');" type="button" class="btn btn-danger btn-sm" title="Delete Data"><i class="fas fa-trash"></i></a> ';

            if($row->status == 1){
                $status = '<span class="badge badge-success">Upcoming</span>';
            }else{
                $status = '<span class="badge badge-danger">Complete</span>';
            }

            $data[] = [
                'id'         => $row->id,
                'reminder_id'=> $row->reminder_id,
                'title'      => $row->title,
                'event_date_time' => '<span class="label label-info">'.date('d, M, Y H:i:s',strtotime($row->event_date_time )).'</span>',
                'status'     => $status,
                'action'     => $button
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
            'title'           => 'required',
            'details'         => 'required',
            'event_date_time' => 'required',
            'status'          => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with('warning', 'Invalid Data');
        }

        try {
            DB::beginTransaction();
            Event::create([
                'title'            => $request->title,
                'details'          => $request->details,
                'event_date_time'  => date('Y-m-d H:i:s', strtotime($request->event_date_time)),
                'status'           => $request->status,
            ]);

            DB::commit();
            return Redirect::route('event.record')->with('message', 'Successfully  Added');
        } catch (\Exception $exception) {
            DB::rollback();
            //return Redirect::back()->with('error',$exception->getMessage());
            return Redirect::back()->withInput()->with('error', 'Failed to save');
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'details' => 'required',
            'event_date_time' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with('warning', 'Invalid Data');
        }

        try {
            DB::beginTransaction();
            $article = Event::find($id);
            $article->title             = $request->title;
            $article->details           = $request->details;
            $article->event_date_time   = date('Y-m-d H:i:s', strtotime($request->event_date_time));
            $article->status            = $request->status;
            $article->save();

            DB::commit();
            return Redirect::route('event.record')->with('message', 'Successfully  Updated');
        } catch (\Exception $exception) {
            DB::rollback();
            // return Redirect::back()->with('error',$exception->getMessage());
            return Redirect::back()->withInput()->with('error', 'Failed to save');
        }
    }

    public function activeEventList()
    {
        return Event::where('status', 1)->get();
    }

    public function eventData($id)
    {
        return Event::find($id);
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
            Event::where('id', $id)->delete();

            DB::commit();
            return ['success' => 'Data delete successfully!'];
        }catch (\Exception $exception){
            DB::rollback();
            return ['error' => 'Data delete failed', 'v_error' => $exception->getMessage()];
        }
    }

    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => ['required'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $file = $request->file('file');
            $fileContents = file($file->getPathname());

            DB::beginTransaction();

            foreach ($fileContents as $line) {
                $data = str_getcsv($line);

                Event::create([
                    'title'   => $data[0],
                    'details' => $data[1],
                    'event_date_time' => date('Y-m-d H:i:s', strtotime($data[2])),
                    'status'  => $data[3]
                ]);
            }

            DB::commit();
            return Redirect::route('event.record')->with('message', 'Successfully  Updated');
        }catch (\Exception $exception){
            DB::rollback();
            return Redirect::back()->withInput()->with('error', 'Failed to save');
        }
    }


}
