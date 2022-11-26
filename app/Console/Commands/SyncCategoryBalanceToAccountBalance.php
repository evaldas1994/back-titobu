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
//            $this->info('User: ' . $user->name);
            foreach ($user->categories as $category) {
                $transfers->add($category->account->transfers
                    ->where('category_id', '=', $category->id)
                    ->where('created_at', '>', Carbon::yesterday()->firstOfMonth())
                    ->where('created_at', '<', Carbon::yesterday()->lastOfMonth())
                );

                $leftBalance = $category->balance - $transfers->collapse()->pluck('amount')->sum();

                $category->account->balance = $category->account->balance + $leftBalance;
                $category->account->save();

//                $this->info('     ' . $category->account->name . ' | ' . $leftBalance . ' | ' . $category->account->balance);
            }
//            $this->info('User: ' . $user->name . ' (DONE)');
        }


//        $this->info('The command was successful! ');
//        $this->error('Something went wrong!');
//        $this->line('Display this on the screen');
        return Command::SUCCESS;
    }
}
