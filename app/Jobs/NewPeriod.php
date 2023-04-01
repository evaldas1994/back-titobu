<?php

namespace App\Jobs;

use App\Models\Period;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewPeriod implements ShouldQueue
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
        $nextMonth = Carbon::today()->addMonth()->format('Y-m');
        $nextPeriod = Period::where('period', $nextMonth)->first();

        if (!$nextPeriod) {
            Period::create([
                'name' => $nextMonth,
                'period' => $nextMonth,
                'user_id' => User::first()?->id,
            ]);
        }
    }
}
