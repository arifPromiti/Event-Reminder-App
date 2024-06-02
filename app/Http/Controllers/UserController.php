<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('user.userList');
    }

    public function getRoles(){
        return Role::whereNotIn('id',[1])->get();
    }

    public function loadUsers(Request $request): array
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
        $totalRecords = User::count('id');

        $query = DB::table('users as a')
                    ->where(function($query) use ($searchValue){
                        $query->where('a.id', 'LIKE', '%'.$searchValue.'%')
                            ->orWhere('a.name', 'LIKE', '%'.$searchValue.'%')
                            ->orWhere('a.email', 'LIKE', '%'.$searchValue.'%');
                    });

        $searchData = $request->searchData;
        $status     = $request->status;

        if (isset($status)) {
            $query = $query->where('a.status', $status);
        }

        if (isset($searchData)) {
            $query = $query->where(function ($query) use ($searchData) {
                $query->where('a.id', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('a.email', 'LIKE', '%' . $searchData . '%');
            });
        }

        $totalRecordswithFilter = $query->count('a.id');

        // Fetch records
        $records = $query->select('a.id',
            'a.name',
            'a.profile_pic',
            'a.email',
            'a.view_password',
            'a.status',)
            ->orderBy($columnName,$columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $row){
            $id = $row->id;

            if($row->status == 1){
                $status = '<span class="badge badge-success">Active</span>';
            }else{
                $status = '<span class="badge badge-danger">Banned</span>';
            }

            $data_arr[] = array(
                'name' => $row->name,
                'email' => $row->email,
                'view_password' =>  $row->view_password,
                'status' => $status,
                'action' => '<a href="javascript:editUser('.$id.');" type="button" class="btn btn-info btn-sm" title="Edit user"><i class="fas fa-edit"></i></a>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecordswithFilter),
            "data" => $data_arr
        );

        return $response;
    }

    public function adduser(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => ['required','min:6'],
            'name' => ['required'],
            'email' => ['required'],
        ]);

        if($validator->fails()){
            return ['msg' => 'Please check the information on the form and correct them', 'v_error' => $validator->errors()];
        }else{
            $data = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'view_password' => $request->input('password'),
                'password' => Hash::make($request->input('password')),
                'status'   => 1,
            ]);

            if($data){
                return ['success' => 'User saved successfully!'];
            }else{
                return ['error' => 'User save failed'];
            }
        }
    }

    public function updateUser(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
        ]);

        if($validator->fails()){
            return ['msg' => 'Please check the information on the form and correct them', 'v_error' => $validator->errors()];
        }else{
            $data = User::where('id','=',$id)
                        ->update([
                            'name'     => $request->input('name'),
                            'email'    => $request->input('email'),
                        ]);

            if($data){
                return ['success' => 'User saved successfully!'];
            }else{
                return ['error' => 'User save failed'];
            }
        }
    }

    public function userInfo($id){
        $data = User::where('id','=',$id)->first();
        return $data;
    }
}
