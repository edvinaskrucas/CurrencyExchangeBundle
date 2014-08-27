<?php namespace Krucas\CurrencyExchangeBundle\Currency;

class Rate
{
    /**
     * Rate.
     *
     * @var float
     */
    protected $rate;

    /**
     * Rate provider.
     *
     * @var string
     */
    protected $providerName;

    /**
     * @param float $rate Rate.
     * @param string $providerName Provider name.
     */
    public function __construct($rate, $providerName)
    {
        $this->rate = $rate;
        $this->providerName = $providerName;
    }

    /**
     * Return rate.
     *
     * @return float
     */
    public function getRate()
    {
        return number_format($this->rate, 4);
    }

    /**
     * Return provider name. NULL is returned when no provider.
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }
}
