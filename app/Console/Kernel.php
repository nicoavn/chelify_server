<?php

namespace App\Console;

use App\FinancialInstrument;
use App\RecurrentTransaction;
use App\Transaction;
use App\TransactionCategory;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        Log::info('Starting the schedule!');
        $schedule->call(function () {
            $now = Carbon::now();
            $recurrentTransactions = RecurrentTransaction::where('day_of_month', $now->day)->get();
            Log::info('Recurrent Transactions: ' . $recurrentTransactions->count());
            foreach($recurrentTransactions as $rt) {
                Log::info('Running recurrent transaction: ' . $rt->title);

                $financialInstrument = FinancialInstrument::find($rt->charge_to);
                $transactionCategory = TransactionCategory::where('icon', RecurrentTransaction::RECURRENT_TRANSACTION_CATEGORY)
                    ->first();

                $transaction = new Transaction;
                $transaction->title = $rt->title;
                $transaction->amount = $rt->amount;
                $transaction->financialInstrument()
                    ->associate($financialInstrument);
                $transaction->category()
                    ->associate($transactionCategory);

                Log::info('Charging: ' . $rt->amount . ' to ' . $financialInstrument->identifier);
                $transaction->save();
            }
        })->dailyAt("14:00");

        Log::info('Ending the schedule!');
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
