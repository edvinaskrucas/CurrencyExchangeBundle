<?php namespace Krucas\CurrencyExchangeBundle\Command;

use Krucas\CurrencyExchangeBundle\Currency\Pair;
use Krucas\CurrencyExchangeBundle\Currency\Rate;
use Krucas\CurrencyExchangeBundle\Service\RateManager;
use Krucas\CurrencyExchangeBundle\Service\RateService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BestRateCommand extends ContainerAwareCommand
{
    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName('currency:rate:best')
            ->setDescription('Show best exchange rate for given currency pair.')
            ->addArgument('from-currency', InputOption::VALUE_REQUIRED, 'From currency')
            ->addArgument('to-currency', InputOption::VALUE_REQUIRED, 'To currency');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RateManager $manager */
        $manager = $this->getContainer()->get('krucas_currency_exchange.service.manager');

        $currencyPair = new Pair($input->getArgument('from-currency'), $input->getArgument('to-currency'));

        $output->writeln('Best rate:');

        /** @var Rate $bestRate */
        $bestRate = $manager->getBestRate($currencyPair);

        $output->writeln('<info>'.$bestRate->getProviderName().' : '.$bestRate->getRate().'</info>');
    }
}
