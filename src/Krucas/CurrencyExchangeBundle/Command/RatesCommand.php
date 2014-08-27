<?php namespace Krucas\CurrencyExchangeBundle\Command;

use Krucas\CurrencyExchangeBundle\Currency\Pair;
use Krucas\CurrencyExchangeBundle\Currency\Rate;
use Krucas\CurrencyExchangeBundle\Service\RateManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RatesCommand extends ContainerAwareCommand
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName('currency:rates')
            ->setDescription('Show exchange rates table for given currency pair.')
            ->addArgument('from-currency', InputOption::VALUE_REQUIRED, 'From currency')
            ->addArgument('to-currency', InputOption::VALUE_REQUIRED, 'To currency');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RateManager $manager */
        $manager = $this->getContainer()->get('krucas_currency_exchange.service.manager');

        $currencyPair = new Pair($input->getArgument('from-currency'), $input->getArgument('to-currency'));

        $output->writeln(
            sprintf(
                '<info>Rates for: %s - %s</info>',
                $currencyPair->getFromCurrency(),
                $currencyPair->getToCurrency()
            )
        );

        $rates = $manager->getRates($currencyPair);

        $table = new Table($output);

        $table->setHeaders(array('Provider', 'Rate'));

        /** @var Rate $rate */
        foreach ($rates as $rate) {
            $table->addRow(array($rate->getProviderName(), $rate->getRate()));
        }

        $table->render();
    }
}
