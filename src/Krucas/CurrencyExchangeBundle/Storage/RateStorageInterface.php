<?php namespace Krucas\CurrencyExchangeBundle\Storage;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

interface RateStorageInterface
{
    /**
     * Store given rates.
     *
     * @param Rates $rates Rates to store.
     * @return bool
     */
    public function store(Rates $rates);

    /**
     * Retrieve rates for given currency pair.
     *
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair to get rates for.
     * @return Rates
     */
    public function retrieve(Pair $currencyPair);

    /**
     * Clear rates.
     *
     * @param Pair $currencyPair Currency pair to clear rates for.
     * @return bool
     */
    public function clear(Pair $currencyPair);
}
