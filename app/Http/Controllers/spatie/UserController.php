<?php

namespace App\Http\Controllers\spatie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use DB;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('user-list'), 403);

        $data = User::orderBy('id','DESC')->first();
        // return $data->getRoleNames();
        // return view('backend.templates.user.show',compact('data'));
        return view('backend.templates.User_Management.user.show');
            // ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        abort_unless(\Gate::allows('user-create'), 403);
        $user = "";
        $roles = Role::pluck('name','name')->all();
        return view('backend.templates.User_Management.user.create',compact('user','roles'));
    }

    public function store(Request $request)
    {
        abort_unless(\Gate::allows('user-create'), 403);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make('123');


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_unless(\Gate::allows('user-edit'), 403);

        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('backend.templates.User_Management.user.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        abort_unless(\Gate::allows('user-edit'), 403);

        // return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required'
        ]);

        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        abort_unless(\Gate::allows('user-delete'), 403);

        $userDestroy = User::find($id);
        // return $id;
        $userDestroy->delete();

        return redirect()->route('users.index')
        ->with('success',' User Deleted Successfully');
    }

    public function getData(){
        // $data = User::query();
        $data = User::all();
        // return $data;
        return Datatables::of($data)
        ->addColumn('action',function ($data){
            $button = '<button type="button" class="edit btn btn-primary btn-sm" data-edit-id="'.$data->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
            $button .= '&nbsp;&nbsp;';
            $button .=  '<button type="button" class="delete btn btn-danger btn-sm" data-delete-id="'.$data->id.'" data-token="'.csrf_token().'" ><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>';
            return $button;
        })
        ->addColumn('role',function ($data){
            return '<label class="badge badge-info">'.$data->getRoleNames()->first().'</label>';
        })
        ->rawColumns(['action','role'])
        ->make(true);
    }
}
