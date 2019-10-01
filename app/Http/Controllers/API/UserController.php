<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\backend\qrcodecontroller;

use Illuminate\Support\Facades\Validator;
// Use For Model
use App\User;
use App\Model\Attendances;

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
		$input['date'] = $_GET['insert'];
		// $input['date'] = '2019-09-30';
		$input['students_masters_id'] = $_GET['user'];
		$input['lectures_id'] = $_GET['lectures'];

		$check = Attendances::where([['date','=',$input['date']],['students_masters_id','=',$input['students_masters_id']]])->first();
		if($check){
			return '<b>Before You Filled</b>';
		}else
		{
			$attendance = Attendances::create($input);
		}
		// dd($input);
		if($attendance)
		{
			$return['return'] = 'Your Attendances Filled';  
			return '<b>Your Attendances Filled</b>';
		}
		$return['return'] = 'Try Again';
		return '<b>Try Again</b>';
	}
}
