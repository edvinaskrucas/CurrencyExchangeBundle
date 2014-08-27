<?php namespace Krucas\CurrencyExchangeBundle\Provider;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

interface ProviderInterface
{
    /**
     * Return rate for given currency pair.
     *
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair to get rate for.
     * @return float
     */
    public function getRate(Pair $currencyPair);

    /**
     * Return provider name.
     *
     * @return string
     */
    public function getName();
}
