<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Model
use App\User;
use App\Model\StudentsMaster;



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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard(){
        $users = array(
            'count' => StudentsMaster::with(['Users'])->count(),
            'title' => "Students"
        );
        return view('backend.templates.dashboard',compact('users'));

    }
}
