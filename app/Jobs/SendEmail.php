<?php

namespace App\Jobs;

use App\Email;
use App\Jobs\Job;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $emails;
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->emails = Email::all();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Email $email)
    {
        //Enviar email
        $i = 1;
        foreach ($this->emails as $this->email) {
            Mail::send('emails.templates.template1-1',
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
        }
    }
}
