<?php

namespace App\Http\Controllers\Dashboard;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmailController extends Controller
{
    public $user;

    private $email;
    private $emails;

    public function __construct()
    {
        $this->user = auth()->user();

        $this->emails = Email::all();
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
