<?php namespace Krucas\CurrencyExchangeBundle\Service;

use Krucas\CurrencyExchangeBundle\Currency\Pair;
use Krucas\CurrencyExchangeBundle\Currency\Rate;
use Krucas\CurrencyExchangeBundle\Provider\ProviderInterface;

class RateService
{
    /**
     * Provider queue.
     *
     * @var \SplPriorityQueue
     */
    protected $providers;

    /**
     * @param array $providers Array of default providers.
     */
    public function __construct(array $providers = array())
    {
        $this->providers = new \SplPriorityQueue();

        $this->registerProviders($providers);
    }

    /**
     * Get providers.
     *
     * @return \SplPriorityQueue
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Register new provider.
     *
     * @param ProviderInterface $provider Provider to register.
     * @param null|int $priority
     * @return RateService
     */
    public function registerProvider(ProviderInterface $provider, $priority = null)
    {
        $this->getProviders()->insert($provider, $priority);

        return $this;
    }

    /**
     * Register array of providers.
     *
     * @param array $providers Array of providers.
     * @return RateService
     */
    public function registerProviders(array $providers = array())
    {
        if (count($providers) > 0) {
            foreach ($providers as $provider) {
                if (is_string($provider)) {
                    if (class_exists($provider)) {
                        $provider = new $provider;
                    }
                }
                $this->registerProvider($provider);
            }
        }

        return $this;
    }

    /**
     * Return rates from all providers for a given currency pair.
     *
     * @param Pair $currencyPair Currency pair to get rates for.
     * @return array
     */
    public function getRates(Pair $currencyPair)
    {
        $rates = array();

        $providers = $this->getProviders();

        /** @var ProviderInterface $provider */
        foreach ($providers as $provider) {
            $rates[] = new Rate($provider->getRate($currencyPair), $provider->getName());
        }

        return $rates;
    }
}
