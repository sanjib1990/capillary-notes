<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Contracts\PricingContract;
use App\Contracts\CabCustomerTransitContract;

/**
 * Class Pricing
 *
 * @package App\Utils
 */
class Pricing implements PricingContract
{
    /**
     * @var CabCustomerTransitContract
     */
    private $transit;

    /**
     * Pricing constructor.
     *
     * @param CabCustomerTransitContract $transit
     */
    public function __construct(CabCustomerTransitContract $transit)
    {
        $this->transit = $transit->load('cab.type');
    }

    /**
     * Get distance between coordinates.
     *
     * @return float
     */
    public function getDistance()
    {
        return round(
            sqrt(
                pow($this->transit->from_lat - $this->transit->to_lat, 2)
                + pow($this->transit->from_lng - $this->transit->to_lng, 2)
            ),
            2
        );
    }

    /**
     * Get time difference in minutes.
     *
     * @return int
     */
    public function getTimeInMinutes()
    {
        return Carbon::parse($this->transit->ended_at)->diffInMinutes(Carbon::parse($this->transit->started_at));
    }

    /**
     * Get calculated price.
     *
     * @return float
     */
    public function getCalculatedPrice()
    {
        $cabType    = data_get($this->transit, 'cab.type');

        return $this->getDistance() * $cabType->price_per_km + $this->getTimeInMinutes() * $cabType->price_per_minute;
    }
}
