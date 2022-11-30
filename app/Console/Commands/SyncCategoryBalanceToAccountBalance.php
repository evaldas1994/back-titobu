<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncCategoryBalanceToAccountBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:syncCategoryBalanceToAccountBalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $transfers = collect();

        foreach (User::all() as $user) {
            foreach ($user->categories as $category) {
                $transfers->add($category->account->transfers
                    ->where('category_id', '=', $category->id)
                    ->where('created_at', '>', Carbon::yesterday()->startOfMonth())
                    ->where('created_at', '<', Carbon::yesterday()->endOfMonth())
                );

                $leftBalance = $category->balance - $transfers->collapse()->pluck('amount')->sum();

                $category->account->balance = $category->account->balance + $leftBalance;
                $category->account->save();

            }
        }
        return Command::SUCCESS;
    }
}
