<?php

namespace App\Http\Controllers\Dashboard;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
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
     * List all emails
     * @return $this
     */
    public function showEmails()
    {
        return view('dashboard.emails.show')->with('user',$this->user->name)->with('list_emails',Email::paginate(15))->with('emails',Email::all());
    }

    /**Show the current email
     * @return $this
     */
    public function editEmails($id)
    {
        $email = Email::find($id);
        return view('dashboard.emails.edit',compact('email'))
            ->with('user',$this->user->name)
            ->with('emails',$this->emails);
    }

    /**
     * Edit the current email
     * @return $this
     */
    public function editEmailsPost($id,Request $request)
    {
        $rules = [
            'name'=>'required',
            'email'=>'required|email',
        ];
        $attributes = [
            'name'=> 'nome'
        ];
        $validator = Validator::make($request->all(),$rules);
        $validator->setAttributeNames($attributes);
        if($validator->fails()){
            return redirect()
                ->to(route('dashboard.showEmails'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        $email = Email::find($id);
        $email->fill($request->all());
        $email->save();

        Flash::success('Contato alterado com sucesso!');
        return redirect()->to(route('dashboard.showEmails'));
    }

    /**
     * Delete the email by id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $email = Email::findOrFail($id);
        $email->delete();
        Flash::success('Email deletado com sucesso!');
        return redirect()->to(route('dashboard.showEmails'));
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
