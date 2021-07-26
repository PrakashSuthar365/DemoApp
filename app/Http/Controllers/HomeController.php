<?php

namespace App\Http\Controllers;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // redirect to user home screeen
        if(auth()->user()->role_id == "1"){
            if(request()->ajax()) {
                return datatables()->of(User::where('role_id',1))
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Block" class="edit btn btn-primary btn-sm blockUser">Block</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('admin_dashboard');

        // redirect to Admin home screen
        } else {
            return view('user_dashboard');
        }
    }

    public function delete($id) {
        User::find($id)->delete();
        return response()->json(['success'=>'User deleted successfully.']);
    }

    public function block($id) {
        dd($id);
    }
}