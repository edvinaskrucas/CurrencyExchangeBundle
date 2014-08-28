<?php

use Mockery as m;

class RateManagerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetRatesFromStorage()
    {
        $manager = $this->getManager(500);

        $pair = new \Krucas\CurrencyExchangeBundle\Currency\Pair('EUR', 'USD');

        $rateArray = array(
            new \Krucas\CurrencyExchangeBundle\Currency\Rate(0.5, 'google')
        );

        $rates = new \Krucas\CurrencyExchangeBundle\Storage\Rates($rateArray, $pair, new \DateTime('now'));

        $manager->getStorage()->shouldReceive('retrieve')->once()->andReturn($rates);
        $manager->getStorage()->shouldReceive('clear')->never();
        $manager->getStorage()->shouldReceive('store')->never();

        $manager->getService()->shouldReceive('getRates')->never();

        $this->assertEquals($manager->getRates($pair), $rateArray);
    }

    public function testGetRatesStoresDataToStorage()
    {
        $manager = $this->getManager();

        $pair = new \Krucas\CurrencyExchangeBundle\Currency\Pair('EUR', 'USD');

        $rateArray = array(
            new \Krucas\CurrencyExchangeBundle\Currency\Rate(0.5, 'google')
        );

        $rates = new \Krucas\CurrencyExchangeBundle\Storage\Rates($rateArray, $pair, new \DateTime('now'));

        $manager->getStorage()->shouldReceive('retrieve')->once()->andReturn($rates);
        $manager->getStorage()->shouldReceive('clear')->once();
        $manager->getStorage()->shouldReceive('store')->once();

        $manager->getService()->shouldReceive('getRates')->once()->andReturn($rateArray);

        $this->assertEquals($manager->getRates($pair), $rateArray);
    }

    public function testGetBestRates()
    {
        $manager = m::mock('Krucas\CurrencyExchangeBundle\Service\RateManager[getRates]',
            array(
                m::mock('Krucas\CurrencyExchangeBundle\Service\RateService'),
                m::mock('Krucas\CurrencyExchangeBundle\Storage\RateStorageInterface'),
                array(
                    'refreshRate' => 500
                )
            )
        );

        $pair = new \Krucas\CurrencyExchangeBundle\Currency\Pair('EUR', 'USD');

        $rates = array(
            new \Krucas\CurrencyExchangeBundle\Currency\Rate(0.5, 'google'),
            new \Krucas\CurrencyExchangeBundle\Currency\Rate(0.6, 'yahoo')
        );

        $manager->shouldReceive('getRates')->once()->andReturn($rates);

        $this->assertEquals($rates[0], $manager->getBestRate($pair));
    }

    public function getManager($refreshRate = 0)
    {
        return new \Krucas\CurrencyExchangeBundle\Service\RateManager(
            m::mock('Krucas\CurrencyExchangeBundle\Service\RateService'),
            m::mock('Krucas\CurrencyExchangeBundle\Storage\RateStorageInterface'),
            array(
                'refreshRate' => $refreshRate
            )
        );
    }
}