<?php

namespace App\Jobs;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EndOfPeriod implements ShouldQueue
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
        $thisMonth = Carbon::today()->format('Y-m');
        $thisPeriod = Period::where('period', $thisMonth)->with('categories', 'categories.transfers')->first();

        foreach ($thisPeriod->categories as $category) {
            $limit = $category->pivot->limit;
            $expenses = $category->transfers->pluck('amount')->sum();

            $category->savings = $category->savings + ($limit - $expenses);
            $category->save();
        }
    }
}
