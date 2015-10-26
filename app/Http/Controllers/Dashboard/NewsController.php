<?php

namespace App\Http\Controllers\Dashboard;

use App\Email;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    public $user;

    private $email;

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

        /*//Recreate the table
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
            Email::create(['name'=>$result->name,'email'=>$result->email,'token'=>bin2hex(random_bytes(30))]);
        }*/

        $this->dispatch(new SendEmail());

        Flash::success("Seus emails estão sendo enviados!");

        return redirect()->to(route('dashboard.getImport'));
    }

    /**
     * @return $this
     */
    public function showEmails()
    {
        return view('dashboard.emails.show')->with('user',$this->user->name)->with('list_emails',Email::paginate(15))->with('emails',Email::all());
    }

    /**
     * Cancel the user subscription
     */
    public function cancelSubscription($token)
    {
        $this->email = Email::where('token','=',$token)->first();

        if($this->email == null){
            throw new NotFoundHttpException;
        }

        Mail::queue([], [], function ($message) {
                $message->from(env('MAIL_ADMIN', null), env('MAIL_ADMIN_NAME',null));
                $message->to(env('MAIL_ADMIN', null), env('MAIL_ADMIN_NAME', null))->subject('Um usuário cancelou a inscrição!');
                $message->setBody("Olá, o usuário ".$this->email->name."<".$this->email->email."> cancelou sua inscrição para receber emails do site, ele também foi automaticamente deletado do banco de dados.");
            });

        // Delete the subscriber
        $this->email->delete();
        return "Sua inscrição foi removida, você não receberá mais emails.";
    }
}
