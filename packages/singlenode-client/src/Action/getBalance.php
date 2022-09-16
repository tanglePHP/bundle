<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\SingleNodeClient\Models\ReturnAddressBalance;

/**
 * Class getBalance
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1150
 */
final class getBalance extends AbstractAction {
  /**
   * @var string
   */
  protected string $addressBech32;
  /**
   * @var array
   */
  protected array $query = [];

  /**
   * @param string $address
   *
   * @return $this
   * @throws ConverterException
   */
  public function address(string $address = ''): self {
    $this->addressBech32 = Converter::addressToBech32($address, TransactionHelper::getClientProtocol_bech32($this->client));

    return $this;
  }

  /**
   * Filter outputs in protocol V2
   * hasStorageDepositReturn,storageDepositReturnAddress,hasExpiration,expirationReturnAddress,expiresBefore,expiresAfter,hasTimelock,timelockedBefore,timelockedAfter,hasNativeTokens,minNativeTokenCount,maxNativeTokenCount,issuer,sender,tag,createdBefore,createdAfter
   *
   * @param array $filter
   *
   * @return self
   */
  public function filter(array $filter): self {
    $this->query = $filter;

    return $this;
  }

  /**
   * @return array
   * @throws ApiException
   * @throws HelperException
   */
  private function run_V1(): ReturnAddressBalance {
    $ret = $this->client->v1->address($this->addressBech32);
    //
    if($this->settings['addMarketData']) {
      $marketData         = $this->client->ENDPOINT->network->marketServer->price();
      $marketData_balance = TransactionHelper::calcMarketData($ret->balance, $marketData->__toArray());
    }

    return new ReturnAddressBalance([
      'balance'            => (string)$ret->balance,
      'addressBech32'      => $this->addressBech32,
      'nativeTokens'       => [],
      'ledgerIndex'        => $ret->ledgerIndex,
      'filter'             => $this->query,
      'marketData'         => $marketData ?? null,
      'marketData_balance' => $marketData_balance ?? null,
    ], $this->client->ENDPOINT->network);
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  private function run_V2(): ReturnAddressBalance {
    //
    $cursor       = null;
    $nativeTokens = [];
    $total        = 0;
    $ledgerIndex  = 0;
    //
    do {
      $response = $this->client->Plugin->Indexer->outputsBasicAddress($this->addressBech32, array_merge(['cursor' => $cursor], $this->query));
      foreach($response->items as $item) {
        $output = $this->client->output($item);
        if(!$output->metadata->isSpent) {
          $total             += (int)$output->output->amount;
          $nativeTokenOutput = $output->output->nativeTokens ?? null;
          if($nativeTokenOutput) {
            $nativeTokens[] = $output->output->nativeTokens;
          }
        }
        $ledgerIndex = $output->metadata->ledgerIndex;
      }
      $cursor = $response->cursor ?? false;
    } while($cursor && count($response->items->__toArray()) > 0);
    //
    if($this->settings['addMarketData']) {
      $marketData         = $this->client->ENDPOINT->network->marketServer->price();
      $marketData_balance = TransactionHelper::calcMarketData($total, $marketData->__toArray());
    }

    return new ReturnAddressBalance([
      'balance'            => (string)$total,
      'addressBech32'      => $this->addressBech32,
      'nativeTokens'       => $nativeTokens,
      'ledgerIndex'        => $ledgerIndex,
      'filter'             => $this->query,
      'marketData'         => $marketData ?? null,
      'marketData_balance' => $marketData_balance ?? null,
    ], $this->client->ENDPOINT->network);
  }


  /**
   * @return JSON
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function run(): ReturnAddressBalance {
    return $this->client->getProtocolVersion() == '1' ? $this->run_V1() : $this->run_V2();
  }
}