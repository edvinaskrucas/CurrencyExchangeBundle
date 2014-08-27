<?php namespace Krucas\CurrencyExchangeBundle\Provider;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

class YahooProvider implements ProviderInterface
{
    /**
     * Return rate for given currency pair.
     *
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair to get rate for.
     * @return float
     */
    public function getRate(Pair $currencyPair)
    {
        return mt_rand(0, 99) / 100;
    }

    /**
     * Return provider name.
     *
     * @return string
     */
    public function getName()
    {
        return 'yahoo';
    }
}
