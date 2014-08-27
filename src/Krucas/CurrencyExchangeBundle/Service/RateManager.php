<?php namespace Krucas\CurrencyExchangeBundle\Service;

use Krucas\CurrencyExchangeBundle\Currency\Pair;
use Krucas\CurrencyExchangeBundle\Currency\Rate;
use Krucas\CurrencyExchangeBundle\Storage\Rates;
use Krucas\CurrencyExchangeBundle\Storage\RateStorageInterface;

class RateManager
{
    /**
     * Rate retrieval service.
     *
     * @var RateService
     */
    protected $service;

    /**
     * Rate storage.
     *
     * @var \Krucas\CurrencyExchangeBundle\Storage\RateStorageInterface
     */
    protected $storage;

    /**
     * Rate refresh rate.
     *
     * @var int
     */
    protected $refreshRate;

    /**
     * @param RateService $service Service to retrieve rates.
     * @param RateStorageInterface $storage Storage to store rates.
     * @param array $options Options to configure manager.
     */
    public function __construct(RateService $service, RateStorageInterface $storage, array $options = array())
    {
        $this->service = $service;
        $this->storage = $storage;

        if (isset($options['refreshRate'])) {
            $this->refreshRate = $options['refreshRate'];
        }
    }

    /**
     * @return RateStorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @return RateService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return int
     */
    public function getRefreshRate()
    {
        return $this->refreshRate;
    }

    /**
     * @param Pair $currencyPair
     * @return array
     */
    public function getRates(Pair $currencyPair)
    {
        $storage = $this->getStorage();

        $now = new \DateTime('now');

        try {
            $rates = $storage->retrieve($currencyPair);

            if ($now->getTimestamp() - $rates->getDate()->getTimestamp() < $this->getRefreshRate()) {
                return $rates->getRates();
            }

            $storage->clear($currencyPair);
        } catch (\Exception $e) {

        }

        $rates = $this->getService()->getRates($currencyPair);

        $storage->store(new Rates($rates, $currencyPair, new \DateTime('now')));

        return $rates;
    }

    /**
     * Return best rate for given currency pair.
     *
     * @param Pair $currencyPair
     * @return Rate
     */
    public function getBestRate(Pair $currencyPair)
    {
        $rates = $this->getRates($currencyPair);

        /** @var Rate $bestRate */
        $bestRate = array_shift($rates);

        if (count($rates) > 0) {
            /** @var Rate $rate */
            foreach ($rates as $rate) {
                if ($rate->getRate() < $bestRate->getRate()) {
                    $bestRate = $rate;
                }
            }
        }

        return $bestRate;
    }
}