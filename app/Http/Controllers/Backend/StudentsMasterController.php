<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// Model
use App\User;
use Spatie\Permission\Models\Role;
use App\Model\StudentsMaster;

// For Password 
use Hash;

// For Date 
use Carbon\Carbon;

// For Datatable
use DB;
use Yajra\Datatables\Datatables;

class StudentsMasterController extends Controller
{
    private $my_file,$email_unique;
    public function __construct(){
        $this->email_unique = array();
        $todate = Carbon::now()->toDateString();
        // $this->my_file = public_path().'/backend/errors/'.$todate.'_file.txt';
        // $handle = fopen($this->my_file, 'w') or die('Cannot open file:  '.$this->my_file);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.templates.Students.show');
    }

    public function create()
    {
        return view('backend.templates.Students.create');
    }

    public function store(Request $request)
    {
        $msgType = "";
        $msg = "";
        // dd($request);
        if ($request->input('submit') != null ){

            $file = $request->file('file');
            // $file = $request->file;

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");

            
            // Check file extension
            if(in_array(strtolower($extension),$valid_extension))
            {
                // 2MB in Bytes
                $maxFileSize = 2097152;

                // Check file size
                if($fileSize <= $maxFileSize){

                    // File upload location
                    $location = 'public/backend/uploads';
                    // dd($location);

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);

                    // Reading file
                    $file = fopen($filepath,"r");

                    $importData_arr = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata );

                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }

                        $i++;
                    }
                    fclose($file);
                    // $role = Role::where('name','=','student')->first();

                    foreach($importData_arr as $importData){


                        $insertData = array(
                        // "id"=>$importData[0],
                            "name"=>$importData[0],
                            "gender"=>$importData[1],
                            "email"=>$importData[2]);

                        if($this->myValidation($insertData))
                        {
                            $input = $insertData;
                            $input['password'] = Hash::make('123456');

                            $user = User::create($input);
                            // dd($user->id);
                            $insert_students_master['user_id'] = $user->id;
                            $insert_students_master['batch'] = $importData[3];
                            $insert_students_master['division'] = $importData[4];
                            StudentsMaster::create($insert_students_master);
                            $user->assignRole('student');
                            // dd("xyz",$role->id);

                            // dd($insert_students_master);
                            $msgType = 'success'; 
                            $msg = 'Import Successful.';
                        }
                        else
                        {
                            // Any Record Genrate Error To Call Else
                            // echo "<br>";
                        }

                    }
                    
                }else{
                    $msgType = 'errors'; 
                    $msg = 'File too large. File must be less than 2MB.';
                }

            }else{
                echo $msgType = 'errors'; 
                $msg = 'Invalid File Extension.';

            }
        }
        else{
            // dd('Last Else');
        }
        // $this->downloadErrorFile();
        // $email_uniques = "";
        $errors = $this->email_unique;
        if($errors > 0)
        {
            // dd("In",$email_uniques);
            // return redirect()->route('students.index',compact('email_uniques'))->with($msgType,$msg);
            if($errors->any())
            {
                print_r($errors);
            }    
            dd();
            return view('backend.templates.Students.show')->with('errors',$email_uniques);
        }
        dd("Else",$email_uniques);
        return view('backend.templates.Students.show',compact('email_uniques'))->with($msgType,$msg);
    }

    private function myValidation($request){

        $validator = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return $this->myError($validator);
        }
        return true;
    }
    private function myError($data){

        // echo $errors = $data->getMessageBag();
        // echo $errors;
        // echo $data->getData()['email'];
        array_push($this->email_unique,$data->getData()['email']);
        // dd("Error",$this->email_unique);

        /************************************************************************************/
        // $handle = fopen($this->my_file, 'a') or die('Cannot open file:  '.$this->my_file);
        // $handle = fopen($this->my_file, 'a');
        // array_push($this->email_unique, $data->getData()['email']);
        
        // $new_data = "\n".$errors;
        // $new_data = "\n".$data->getData()['email']." email has already been taken.";
        // fwrite($handle, $new_data);

        //write some data here
        // fclose($handle);
        return FALSE;
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

    public function getData(){

        $data = StudentsMaster::with(['Users'])->get();
        // dd($data);
        // return $data;
        
        return Datatables::of($data)
        ->addColumn('action',function ($data){
            $button = '<button type="button" class="edit btn btn-primary btn-sm" data-edit-id="'.$data->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
            $button .= '&nbsp;&nbsp;';
            $button .=  '<button type="button" class="delete btn btn-danger btn-sm" data-delete-id="'.$data->id.'" data-token="'.csrf_token().'" ><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>';
            return $button;
        })
        ->addColumn('userName',function($data){
            return $data->Users->name;
        })
        ->addColumn('userEmail',function($data){
            return $data->Users->email;
        })
        ->rawColumns(['action','userName','userEmail'])
        ->make(true);
    }
}
