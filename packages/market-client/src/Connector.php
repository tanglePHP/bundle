<?php namespace tanglePHP\MarketClient;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractConnector;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\Coin;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\CoinHistory;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\CoinMarketChart;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\CoinMarketChartRange;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\Info;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\Price;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Connector
 *
 * @package      tanglePHP\MarketClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1216
 */
final class Connector extends AbstractConnector {
  /**
   * @var string
   */
  protected string $coinId;

  /**
   * @return void
   */
  public function onConstruct(): void {
    $this->coinId = strtolower($this->ENDPOINT->network->info['baseToken']);
  }

  /**
   * @return Info|JSON
   * @throws ApiException
   * @throws HelperException
   */
  public function ping(): Info|JSON {
    return $this->API_CALLER->route('ping')
                            ->callback(Info::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string|array $currencies
   *
   * @return Price
   * @throws ApiException
   * @throws HelperException
   */
  public function price(string|array $currencies = 'usd,eur'): Price {
    if(is_array($currencies)) {
      $currencies = implode(',', $currencies);
    }
    $query = [
      'ids'                     => $this->coinId,
      'vs_currencies'           => $currencies,
      'include_last_updated_at' => 'true',
    ];
    //
    $ret = $this->API_CALLER->route('simple/price')
                            ->query($query)
                            ->callback(Price::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
    //
    isset($ret->status) ? $ret = new Price($this->ENDPOINT->network->readTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp')) : $this->ENDPOINT->network->writeTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp', $ret);

    return $ret;
  }

  /**
   * @return Coin
   * @throws ApiException
   * @throws HelperException
   */
  public function coin(): Coin {
    $ret = $this->API_CALLER->route('coins/' . $this->coinId)
                            ->callback(Coin::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
    //
    isset($ret->status) ? $ret = new Price($this->ENDPOINT->network->readTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp')) : $this->ENDPOINT->network->writeTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp', $ret);

    return $ret;
  }

  /**
   * @param string|null $date
   *
   * @return CoinHistory
   * @throws ApiException
   * @throws HelperException
   */
  public function coinHistory(?string $date = null): CoinHistory {
    $query = [
      'date' => $date ?? date("d-m-Y"),
    ];
    $ret   = $this->API_CALLER->route('coins/' . $this->coinId . '/history')
                              ->query($query)
                              ->callback(CoinHistory::class)
                              ->fetchJSON($this->ENDPOINT->TIMEOUT);
    //
    isset($ret->status) ? $ret = new Price($this->ENDPOINT->network->readTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp')) : $this->ENDPOINT->network->writeTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp', $ret);

    return $ret;
  }

  /**
   * @param int    $days
   * @param string $vs_currency
   *
   * @return CoinMarketChart
   * @throws ApiException
   * @throws HelperException
   */
  public function coinMarketChart(int $days = 7, string $vs_currency = 'usd'): CoinMarketChart {
    $query = [
      'vs_currency' => $vs_currency,
      'days'        => $days,
    ];
    $ret   = $this->API_CALLER->route('coins/' . $this->coinId . '/market_chart')
                              ->query($query)
                              ->callback(CoinMarketChart::class)
                              ->fetchJSON($this->ENDPOINT->TIMEOUT);
    //
    isset($ret->status) ? $ret = new Price($this->ENDPOINT->network->readTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp')) : $this->ENDPOINT->network->writeTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp', $ret);

    return $ret;
  }

  /**
   * @param int      $from
   * @param int|null $to
   * @param string   $vs_currency
   *
   * @return CoinMarketChartRange
   * @throws ApiException
   * @throws HelperException
   */
  public function coinMarketChartRange(int $from, ?int $to = null, string $vs_currency = 'usd'): CoinMarketChartRange {
    $query = [
      'vs_currency' => $vs_currency,
      'from'        => $from,
      'to'          => $to ?? time(),
    ];
    $ret   = $this->API_CALLER->route('coins/' . $this->coinId . '/market_chart/range')
                              ->query($query)
                              ->callback(CoinMarketChartRange::class)
                              ->fetchJSON($this->ENDPOINT->TIMEOUT);
    //
    isset($ret->status) ? $ret = new Price($this->ENDPOINT->network->readTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp')) : $this->ENDPOINT->network->writeTmpFile('market-client-' . __FUNCTION__ . '-' . $this->coinId . '.tmp', $ret);

    return $ret;
  }
}