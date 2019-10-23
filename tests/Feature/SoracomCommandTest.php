<?php

namespace Tests\Feature;

use Tests\TestCase;

class SoracomCommandTest extends TestCase
{
    public function testLatestBillingCommand()
    {
        $this->artisan('soracom:latest')
             ->assertExitCode(0);
    }
}
