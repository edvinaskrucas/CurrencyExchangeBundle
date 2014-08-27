<?php namespace Krucas\CurrencyExchangeBundle\Storage;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

class Rates
{
    /**
     * @var array
     */
    protected $rates;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * Currency pair.
     *
     * @var Pair
     */
    protected $currencyPair;

    /**
     * @param array $rates Rates.
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair.
     * @param \DateTime $time Rates time.
     */
    public function __construct(array $rates = array(), Pair $currencyPair, \DateTime $time)
    {
        $this->rates = $rates;
        $this->date = $time;
        $this->currencyPair = $currencyPair;
    }

    /**
     * Return rates.
     *
     * @return array
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Return date of rates.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Return currency pair.
     *
     * @return Pair
     */
    public function getCurrencyPair()
    {
        return $this->currencyPair;
    }
}