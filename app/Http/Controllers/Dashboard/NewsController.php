<?php

namespace App\Http\Controllers\Dashboard;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class NewsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }


    /**
     * Import contacts
     */
    public function getImport(){
        return view('dashboard.emails.import')
            ->with('user',$this->user->name)
            ->with('emails',Email::all());
    }

    /**
     *
     * Handle post Import contacts
     */
    public function postImport(Request $request){
        $validator = Validator::make($request->all(),['table'=>'required|mimes:csv,txt']);

        if ($validator->fails()) {
            return redirect()->to(route('dashboard.getImport'))
                ->withErrors($validator)
                ->withInput();
        }

        //Truncate the table
        Schema::drop('emails');
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });

        $results = Excel::load($request->file('table'), function($reader){
            $reader->ignoreEmpty();
            $reader->all();
        }, 'UTF-8')->get();
        foreach($results as $result){
            Email::create(['name'=>$result->name,'email'=>$result->email]);
        }

        Flash::success("Tabela importada com sucesso");

        return redirect()->to(route('dashboard.getImport'));
    }

    public function showEmails()
    {
        return view('dashboard.emails.show')->with('user',$this->user->name)->with('list_emails',Email::paginate(15))->with('emails',Email::all());
    }
}
