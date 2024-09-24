<?php

namespace App\Jobs;

use App\Mail\ForgottenCartMail;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Themosis\Core\Bus\Dispatchable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessForgottenCart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener la fecha y hora actual
        $now = Carbon::now();

        // Obtener todos los registros de la tabla "registrations" donde la fecha de creación es menor o igual a la actual menos 2 horas
        $registrations = DB::table('registration')
            ->where('created_at', '<=', $now->subHours(1))
            ->where('step', '!=', 'finished')
            ->where('reminder_done', '!=', true)
            ->get();
        Log::info(count($registrations));
        if (!empty($registrations)) {
            foreach ($registrations as $registration) {
                $link = env('LINK_CART') . '?id=' . $registration->mark_id . '&email=' . $registration->email . '&step=' . $registration->step;
                Log::info($registration->id);
                DB::table('registration')->where('mark_id', $registration->mark_id)->update(['reminder_done' => true]);
                // Enviar un correo electrónico al usuario

                $general_info = get_field('mail_info', 'option');

                $data = [
                    'link' => $link,
                    'whatsapp' => isset($general_info['whastapp']) && !empty($general_info['whastapp']) ? $general_info['whastapp'] : '',
                    'rrss_mail' => isset($general_info['rrss_mail']) ? $general_info['rrss_mail'] : []
                ];

                try {
                    //code...
                    $emails_fm = get_field('emails', 'option');
                    $emails_cc = (new Post())->getTextArray($emails_fm['emails_cc'], 'email');
                    $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');

                    Mail::to($registration->email)->bcc($emails_bcc)->send(new ForgottenCartMail('Olvidaste terminar tu registro ', $data));
                } catch (\Exception $e) {
                    Log::info('No se logró enviar el correo');
                    Log::error($e);
                }
            }
        }
    }
}
