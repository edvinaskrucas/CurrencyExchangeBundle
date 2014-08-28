<?php

use Mockery as m;

class RateServiceTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetRatesCallsEachProviderAndReturnsResults()
    {
        $service = new \Krucas\CurrencyExchangeBundle\Service\RateService();

        $provider1 = m::mock('Krucas\CurrencyExchangeBundle\Provider\ProviderInterface');
        $provider1->shouldReceive('getName')->once()->andReturn('google');
        $provider1->shouldReceive('getRate')->once()->andReturn(0.5);

        $provider2 = m::mock('Krucas\CurrencyExchangeBundle\Provider\ProviderInterface');
        $provider2->shouldReceive('getName')->once()->andReturn('yahoo');
        $provider2->shouldReceive('getRate')->once()->andReturn(0.6);

        $service->registerProvider($provider1);
        $service->registerProvider($provider2);

        $results = $service->getRates(new \Krucas\CurrencyExchangeBundle\Currency\Pair('EUR', 'USD'));

        $this->assertCount(2, $results);

        $this->assertEquals($results[0]->getProviderName(), 'google');
        $this->assertEquals($results[0]->getRate(), '0.5000');
        $this->assertEquals($results[1]->getProviderName(), 'yahoo');
        $this->assertEquals($results[1]->getRate(), '0.6000');
    }
}