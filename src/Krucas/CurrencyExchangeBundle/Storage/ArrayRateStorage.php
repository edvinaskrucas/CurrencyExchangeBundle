<?php namespace Krucas\CurrencyExchangeBundle\Storage;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

class ArrayRateStorage extends AbstractRateStorage
{
    /**
     * @var Rates
     */
    protected $rates = array();

    /**
     * Store given rates.
     *
     * @param Rates $rates Rates to store.
     * @return bool
     */
    public function store(Rates $rates)
    {
        $this->rates[$this->getStoreKey($rates->getCurrencyPair())] = $rates;

        return true;
    }

    /**
     * Retrieve rates for given currency pair.
     *
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair to get rates for.
     * @throws \Exception
     * @return Rates
     */
    public function retrieve(Pair $currencyPair)
    {
        if (array_key_exists($this->getStoreKey($currencyPair), $this->rates)) {
            return $this->rates[$this->getStoreKey($currencyPair)];
        }

        throw new \Exception();
    }

    /**
     * Clear rates.
     *
     * @param Pair $currencyPair Currency pair to clear rates for.
     * @return bool
     */
    public function clear(Pair $currencyPair)
    {
        unset($this->rates[$this->getStoreKey($currencyPair)]);

        return true;
    }
}