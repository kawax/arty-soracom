<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\AnonymousNotifiable;

use App\Notifications\SoracomNotification;
use Revolution\Soracom\Facades\Soracom;

class SoracomCommandTest extends TestCase
{
    public function testLatestBillingCommand()
    {
        Notification::fake();

        Soracom::shouldReceive('auth->getLatestBilling')->once()->andReturn([
            'lastEvaluatedTime' => 1,
            'amount'            => 1,
        ]);

        $this->artisan('soracom:latest')
             ->assertExitCode(0);

        Notification::assertSentTo(
            new AnonymousNotifiable, SoracomNotification::class
        );
    }
}
