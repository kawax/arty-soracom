<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use Revolution\Soracom\Facades\Soracom;
use Illuminate\Support\Facades\Notification;

use App\Notifications\SoracomNotification;

class LatestBillingCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'soracom:latest';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = Soracom::auth()->getLatestBilling();

        //        $this->info($res['lastEvaluatedTime']);
        //        $this->info($res['amount']);

        Notification::route('discord', config('services.discord.channel'))
                    ->notify(new SoracomNotification($res));
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
