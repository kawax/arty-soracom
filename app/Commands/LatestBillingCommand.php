<?php

namespace App\Commands;

use App\Notifications\SoracomNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;
use LaravelZero\Framework\Commands\Command;
use Revolution\Soracom\Facades\Soracom;

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
                    ->route('line-notify', config('line.notify.personal_access_token'))
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
