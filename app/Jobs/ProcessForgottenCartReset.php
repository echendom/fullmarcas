<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Themosis\Core\Bus\Dispatchable;

class ProcessForgottenCartReset implements ShouldQueue
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
        $now = Carbon::now();

        DB::table('registration')
            ->where('updated_at', '<=', $now->subHours(2))
            ->where('date_finish', null)
            ->where('step', '!=', 'step-5')
            ->where('reminder_done', '=', true)
            ->update(['reminder_done' => false]);
    }
}
