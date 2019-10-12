<?php

namespace Revolution\Soracom\Concerns;

trait Billing
{
    /**
     * @return array
     */
    public function getLatestBilling()
    {
        return $this->get('/bills/latest');
    }
}
