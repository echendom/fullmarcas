<?php

namespace App\Jobs;

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

class ProcessForgottenCartHubspot implements ShouldQueue
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
            ->where('created_at', '<=', $now->subHours(24))
            ->where('step', '!=', 'finished')
            ->whereNull('reminder_hubspot_done')
            ->get();

        
        Log::info(count($registrations));
        if (!empty($registrations)) {
            foreach ($registrations as $registration) {
                Log::info($registration->id);
                DB::table('registration')->where('mark_id', $registration->mark_id)->update(['reminder_hubspot_done' => true]);

                $payload = array(
                    "fields" => array(
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "email",
                            "value" => $registration->email
                        ),
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "mark_denomination",
                            "value" => $registration->mark_denomination
                        ),
                    ),
                );
    
                $payload = json_encode($payload);
                $hubspot = get_field('hubspot', 'option');
                $ch = curl_init('https://api.hsforms.com/submissions/v3/integration/submit/' . $hubspot['portal_id'] . '/' .  $hubspot['cart_form_id']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultado = curl_exec($ch);
                curl_close($ch);
            }
        }
    }
}
