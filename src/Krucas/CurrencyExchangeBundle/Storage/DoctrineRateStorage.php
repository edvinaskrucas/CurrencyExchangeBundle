<?php namespace Krucas\CurrencyExchangeBundle\Storage;

use Doctrine\DBAL\Connection;
use Krucas\CurrencyExchangeBundle\Currency\Pair;
use Krucas\CurrencyExchangeBundle\Currency\Rate;

class DoctrineRateStorage extends AbstractRateStorage
{
    /**
     * DBAL connection.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    /**
     * @param Connection $connection
     * @param $table
     */
    public function __construct(Connection $connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Store given rates.
     *
     * @param Rates $rates Rates to store.
     * @return bool
     */
    public function store(Rates $rates)
    {
        $key = $this->getStoreKey($rates->getCurrencyPair());
        $date = $rates->getDate()->getTimestamp();

        /** @var Rate $rate */
        foreach ($rates->getRates() as $rate) {
            $this->getConnection()->insert(
                $this->getTable(),
                array(
                    'ck'        => $key,
                    'provider'  => $rate->getProviderName(),
                    'rate'      => $rate->getRate(),
                    'date'      => $date
                )
            );
        }

        return true;
    }

    /**
     * Retrieve rates for given currency pair.
     *
     * @param \Krucas\CurrencyExchangeBundle\Currency\Pair $currencyPair Currency pair to ger rates for.
     * @return Rates
     */
    public function retrieve(Pair $currencyPair)
    {
        $statement = "SELECT * FROM ".$this->getTable()." WHERE ck = ?";

        $rows = $this->getConnection()->fetchAll($statement, array($this->getStoreKey($currencyPair)));

        $rates = array();

        foreach ($rows as $row) {
            $rates[] = new Rate($row['rate'], $row['provider']);
        }

        $date = new \DateTime();

        $date->setTimestamp(isset($row) ? $row['date'] : 0);

        return new Rates($rates, $currencyPair, $date);
    }

    /**
     * Clear rates.
     *
     * @param Pair $currencyPair Currency pair to clear rates for.
     * @return bool
     */
    public function clear(Pair $currencyPair)
    {
        $this->getConnection()->delete($this->getTable(), array('ck' => $this->getStoreKey($currencyPair)));

        return true;
    }
}