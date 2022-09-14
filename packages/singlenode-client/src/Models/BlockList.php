<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Payload\Transaction;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class BlockList
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class BlockList {
  /**
   * @var array
   */
  public array $list = [];

  /**
   * @param Connector $client
   */
  public function __construct(public Connector $client) {
  }

  /**
   * @param Transaction    $payload
   * @param array          $settings
   * @param string|null    $name
   * @param ReturnNFT|null $metadata
   *
   * @return void
   * @throws ConverterException
   * @throws HelperException
   */
  public function add(Transaction $payload, array $settings, ?string $name = null, null|ReturnNFT $metadata = null): void {
    $this->list[] = [
      'type'          => 'transaction',
      'payload'       => $payload,
      'name'          => $name,
      'serializedHex' => $payload->serializeToHex(),
      'json'          => $payload->__toJSON(),
      'settings'      => $settings,
      'submitResult'  => null,
      'metadata'      => $metadata,
    ];
  }

  /**
   * @param int    $index
   * @param string $need
   *
   * @return Transaction|null
   */
  public function get(int $index, string $need = 'payload'): Transaction|null {
    return $this->list[$index][$need] ?? null;
  }

  /**
   * @return array
   * @throws ApiException
   * @throws HelperException
   */
  public function submit(): array {
    foreach($this->list as $key => $block) {
      $submitResult = TransactionHelper::submit($this->client, $block['payload'], $this->list[$key]['settings']);
      if(isset($submitResult->blockId)) {
        if($block['metadata'] instanceof ReturnNFT) {
          $block['metadata']->blockId = $submitResult->blockId;
        }
      }
      $submitResult->metadata           = $block['metadata'];
      $this->list[$key]['submitResult'] = $submitResult;
    }

    return $this->getSubmitResult();
  }

  /**
   * @return array
   */
  public function getSubmitResult(): array {
    return array_column($this->list, 'submitResult');
  }
}