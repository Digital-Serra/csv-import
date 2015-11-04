<?php

namespace App\Http\Controllers\Dashboard;

use App\Email;
use Bogardo\Mailgun\Facades\Mailgun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImportController extends Controller
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
     * Import contacts
     */
    public function getImport(){
        return view('dashboard.emails.import')
            ->with('user',$this->user->name)
            ->with('emails',$this->emails);
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

        //Dettach excel file line per line
        $results = Excel::load($request->file('table'), function($reader){
            $reader->ignoreEmpty();
            $reader->all();
        }, 'UTF-8')->get();
        foreach($results as $result){
            if(Email::where('email','=',trim($result->email))->first() == []){
                Email::create(['name'=>$result->name,'email'=>trim($result->email),'token'=>bin2hex(random_bytes(30))]);
            }
        }

        /*//Enviar email
        $i = 1;
        foreach ($this->emails as $this->email) {
            Mail::queue('emails.templates.template1-1',
                [
                    'name' => $this->email->name,
                    'token' => $this->email->token,
                    'email' => $this->email->email,
                    'title' => 'Elecomp Soluções em Tecnologia',
                ], function ($message) {
                    $message->from(env('MAIL_ADMIN', null), env('MAIL_ADMIN_NAME',null))
                        ->to($this->email->email, $this->email->name)
                        ->subject('Oi, '.$this->email->name.', ofertas exclusivas você encontra na Elecomp!‏');
                });

            //Log emails sended
            Log::info('Email número ' . $i . ' enviado para ' . $this->email->nome . ' <' . $this->email->email . '> em ' . Carbon::now()->format('d/m/Y H:m:s'));

            $i++;
        }*/

        Flash::success("Contatos importados com sucesso!");

        return redirect()->to(route('dashboard.getImport'));
    }
}
