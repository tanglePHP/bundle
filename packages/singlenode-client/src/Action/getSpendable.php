<?php namespace tanglePHP\SingleNodeClient\Action;

use SodiumException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\SingleNodeClient\Models\ReturnAddressInfo;

/**
 * Class getSpendable
 *
 * @package      tanglePHP\SingleNodeClient\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.25-1002
 */
final class getSpendable extends AbstractAction {
  /**
   * @var string
   */
  protected string $addressBech32;
  /**
   * @var array
   */
  protected array $query = [
    'hasStorageDepositReturn' => false,
    'hasExpiration'           => false,
    'hasTimelock'             => false,
  ];

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
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  private function run_V1(): array {
    $ret      = [];
    $response = $this->client->v1->addressesOutput($this->addressBech32, 0, false);
    foreach($response->outputIds as $item) {
      $output          = $this->client->output($item);
      $block           = $this->client->block($output->messageId);
      $messageMetadata = $this->client->v1->messageMetadata($output->messageId);
      $milestone       = $this->client->v1->milestoneByIndex($messageMetadata->referencedByMilestoneIndex);
      //
      $amount = 0;
      foreach($block->payload->essence->outputs as $essenceOutput) {
        if(isset($essenceOutput['address']['address']) && Converter::ed25519ToBech32($essenceOutput['address']['address'], TransactionHelper::getClientProtocol_bech32($this->client)) == $this->addressBech32) {
          $amount = $amount + $essenceOutput['amount'];
        }
      }
      //
      $ret[] = new ReturnAddressInfo([
        'addressFrom'              => TransactionHelper::getSenderFromUnlocks($block->payload->unlockBlocks, $this->client),
        'addressTo'                => $this->addressBech32,
        'amount'                   => $amount,
        'milestoneIndexBooked'     => $messageMetadata->referencedByMilestoneIndex,
        'milestoneTimestampBooked' => $milestone->timestamp,
        'datetime'                 => date("Y-m-d H:i:s", $milestone->timestamp),
        'outputId'                 => $item,
        'blockId'                  => $output->messageId,
        'transactionId'            => $output->messageId,
        'explorerUrl'              => $this->client->ENDPOINT->network->getExplorerUrlMessage($output->messageId),
      ], $this->client->ENDPOINT->network);
    }

    return $ret;
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  private function run_V2(): array {
    $cursor = null;
    $ret    = [];
    //
    do {
      $response = $this->client->addressOutput($this->addressBech32, array_merge(['cursor' => $cursor], $this->query));
      foreach($response->items as $item) {
        $output = $this->client->output($item);
        if(!$output->metadata->isSpent) {
          $block = $this->client->block($output->metadata->blockId);
          //
          $amount = 0;
          foreach($block->payload->essence->outputs as $essenceOutput) {
            if(TransactionHelper::getSenderFromUnlocks($essenceOutput->unlockConditions, $this->client) == $this->addressBech32) {
              $amount = $amount + $essenceOutput->amount;
            }
          }
          //
          $ret[] = new ReturnAddressInfo([
            'addressFrom'              => TransactionHelper::getSenderFromUnlocks($block->payload->unlocks, $this->client),
            'addressTo'                => $this->addressBech32,
            'amount'                   => $amount,
            'milestoneIndexBooked'     => $output->metadata->milestoneIndexBooked,
            'milestoneTimestampBooked' => $output->metadata->milestoneTimestampBooked,
            'datetime'                 => date("Y-m-d H:i:s", $output->metadata->milestoneTimestampBooked),
            'outputId'                 => $item,
            'blockId'                  => $output->metadata->blockId,
            'transactionId'            => $output->metadata->transactionId,
            'explorerUrl'              => $this->client->ENDPOINT->network->getExplorerUrlBlock($output->metadata->blockId),
          ], $this->client->ENDPOINT->network);
        }
      }
      $cursor = $response->cursor ?? false;
    } while($cursor && count($response->items->__toArray()) > 0);

    return $ret;
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  public function run(): array {
    return $this->client->getProtocolVersion() == '1' ? $this->run_V1() : $this->run_V2();
  }
}