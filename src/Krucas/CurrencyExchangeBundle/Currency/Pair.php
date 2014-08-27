<?php namespace Krucas\CurrencyExchangeBundle\Currency;

class Pair
{
    /**
     * From currency.
     *
     * @var string
     */
    protected $from;

    /**
     * To currency.
     *
     * @var string
     */
    protected $to;

    /**
     * @param string $from From currency.
     * @param string $to To currency.
     */
    public function __construct($from, $to)
    {
        $this->from =$from;
        $this->to = $to;
    }

    /**
     * Get from currency name.
     *
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->from;
    }

    /**
     * Get to currency name.
     *
     * @return string
     */
    public function getToCurrency()
    {
        return $this->to;
    }
}