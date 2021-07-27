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
        try {
            if(auth()->user()->role_id == "1"){
                if(request()->ajax()) {
                    return datatables()->of(User::where('role_id',2))
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser" >Delete</a>';
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
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            User::find($id)->delete();
            return response()->json(['success'=>'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}