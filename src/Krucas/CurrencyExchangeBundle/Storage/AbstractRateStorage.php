<?php namespace Krucas\CurrencyExchangeBundle\Storage;

use Krucas\CurrencyExchangeBundle\Currency\Pair;

abstract class AbstractRateStorage implements RateStorageInterface
{
    /**
     * Return storage key.
     *
     * @param Pair $currencyPair
     * @return string
     */
    protected function getStoreKey(Pair $currencyPair)
    {
        return join('_', array($currencyPair->getFromCurrency(), $currencyPair->getToCurrency()));
    }
}