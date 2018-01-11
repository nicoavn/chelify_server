<?php

namespace App\Console;

use App\FinancialInstrument;
use App\RecurrentTransaction;
use App\Transaction;
use App\TransactionCategory;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
//            DB::table('recent_users')->delete();
            $now = Carbon::now();
            $recurrentTransactions = RecurrentTransaction::where('day_of_month', $now->day)->get();
            foreach($recurrentTransactions as $rt) {

                $financialInstrument = FinancialInstrument::find($rt->charge_to);
                $transactionCategory = TransactionCategory::find('icon', RecurrentTransaction::RECURRENT_TRANSACTION_CATEGORY);

                $transaction = new Transaction;
                $transaction->title = $rt->title;
                $transaction->amount = $rt->amount;
                $transaction->financialInstrument()
                    ->associate($financialInstrument);

                $transaction->category()
                    ->associate($transactionCategory);

                $transaction->save();
            }

        })->dailyAt("00:21");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
