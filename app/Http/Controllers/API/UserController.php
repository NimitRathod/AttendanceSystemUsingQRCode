<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers\backend\qrcodecontroller;

class UserController extends Controller
{
	public function getData(){

		$result = User::orderBy('id','DESC')->get();

		$response = [
			'success' => true,
			'data'    => $result,
			'message' => 'Users retrieved successfully.',
		];


		return response()->json($response, 200);
	}

	public function index(Request $request)
	{
		// return qrcodecontroller::index();
		$input['date'] = $_GET['insert'];
		$input['user_id'] = $_GET['user'];
		return $input;
		// return 200;
	}
}
