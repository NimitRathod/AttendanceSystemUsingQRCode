<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Hash;

class qrcodecontroller extends Controller
{
    /**
     * Display a listing of th$dt     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $qr = $this->genrate_qr_code();
        // dd($qr);
        return view('backend.templates.Qrcode.create',compact('qr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd("ok");
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function genrate_qr_code(){
        // $dt = Carbon::today();
        $dt = Carbon::now()->toDateString();
        $host = request()->getHttpHost();
        $lectures = 1;
        $qr_bind = "insert=".$dt.'&user='.Auth::user()->id."&lectures=".$lectures;
        $qr = "http://".$host."/api/insert?".$qr_bind;
        // $qr = "http://nhrathod.cf/";
        // $qr = "nhrathod.cf/"; // => this is wrong 
        return \QrCode::size(250)->generate($qr);
        // \QrCode::size(500)
        // ->format('png')
        // ->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));
    }
}
