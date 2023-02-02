<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use SodiumException;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Models\ReturnNFT;

/**
 * Class getNFT
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.24-1101
 */
final class getNFT extends AbstractAction {
  /**
   * @var string
   */
  protected string $addressBech32;

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
   * @return bool
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  private function getNFT(): bool {
    $cursor = null;
    $nfts   = [];
    $_nfts  = [];
    do {
      $response = $this->client->Plugin->Indexer->outputsNft($this->addressBech32, ['cursor' => $cursor]);
      foreach($response->items as $outputId) {
        $_nfts[] = $output = $this->client->output($outputId);
        // create nftId Ed25519
        $output->output->nftId = TransactionHelper::resolveIdFromOutputId($outputId);
        // create nftId bech32
        $output->output->nftId_bech32 = TransactionHelper::nftId2Bech32($output->output->nftId, $this->client);
        // find data
        $data = [
          'hex'   => '',
          'plain' => '',
          'array' => [],
        ];
        foreach($output->output->immutableFeatures as $feature) {
          if($feature->type == 2) {
            $data = TransactionHelper::parseData($feature->data);
          }
          if($feature->type == 1) {
            $immutableIssuer        = Converter::remove0x($feature->address->pubKeyHash);
            $immutableIssuer_bech32 = Converter::ed25519ToBech32($immutableIssuer, TransactionHelper::getClientProtocol_bech32($this->client));
          }
        }
        foreach($output->output->features ?? [] as $feature) {
          if($feature->type == 2) {
            $dataMutable = TransactionHelper::parseData($feature->data);
          }
          if($feature->type == 1) {
            $mutableIssuer        = Converter::remove0x($feature->address->pubKeyHash);
            $mutableIssuer_bech32 = Converter::ed25519ToBech32($mutableIssuer, TransactionHelper::getClientProtocol_bech32($this->client));
          }
        }
        $nfts[] = new ReturnNFT([
          'blockId'                => $output->metadata->blockId,
          'transactionId'          => $output->metadata->transactionId,
          'nftId'                  => $output->output->nftId,
          'nftId_bech32'           => $output->output->nftId_bech32,
          'explorerUrl'            => $this->client->ENDPOINT->network->getExplorerUrlNFT($output->output->nftId_bech32),
          'data'                   => $data,
          'data_mutable'           => $dataMutable ?? [],
          'immutableIssuer'        => $immutableIssuer,
          'immutableIssuer_bech32' => $immutableIssuer_bech32,
        ], $this->client->ENDPOINT->network);
      }
      $cursor = $response->cursor ?? false;
    } while($cursor && count($response->items->__toArray()) > 0);
    //
    $this->result = JSON::create([
      'count' => count($nfts),
      'nfts'  => $nfts,
      '_nfts' => $_nfts,
    ]);

    return true;
  }

  /**
   * @return JSON|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  public function run(): JSON|Error {
    if($this->client->getProtocolVersion() == '1') {
      $this->error(905, "NFTs are not supported in protocol V1");
    }
    else {
      $this->getNFT();
    }

    return $this->result;
  }
}