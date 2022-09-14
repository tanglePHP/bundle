<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Network\Connect;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessageMetadata;
use tanglePHP\SingleNodeClient\Api\v2\Response\BlockMetadata;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class checkTransaction
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1150
 */
final class checkTransaction extends AbstractAction {
  /**
   * @var array|string[]
   */
  public array $conflictReason = [
    1   => "the referenced UTXO was already spent.",
    2   => "the referenced UTXO was already spent while confirming this milestone.",
    3   => "the referenced UTXO cannot be found.",
    4   => "the sum of the inputs and output values does not match.",
    5   => "the unlock block signature is invalid.",
    6   => "the configured timelock is not yet expired.",
    7   => "the given native tokens are invalid.",
    8   => "the return amount in a transaction is not fulfilled by the output side.",
    9   => "the input unlock is invalid.",
    10  => "the inputs commitment is invalid.",
    11  => "an output contains a Sender with an ident (address) which is not unlocked.",
    12  => "the chain state transition is invalid.",
    255 => "the semantic validation failed.",
  ];
  /**
   * @var array|string[]
   */
  public array $conflictReasonV1 = [
    1 => "referenced UTXO was already spent.",
    2 => "referenced UTXO was already spent while confirming this milestone.",
    3 => "referenced UTXO cannot be found.",
    4 => "sum of the inputs and output values does not match.",
    5 => "unlock block signature is invalid.",
    6 => "input or output type used is unsupported.",
    7 => "used address type is unsupported.",
    8 => "dust allowance for the address is invalid.",
    9 => "semantic validation failed.",
  ];
  /**
   * @var string
   */
  protected string $blockId;
  /**
   * @var int
   */
  public int $checkLimit = 15;
  /**
   * @var int
   */
  public int $checkWait = 2;
  /**
   * @var int
   */
  private int $checkCount;

  /**
   * @param Connector|Connect|string $client
   *
   * @throws ApiException
   * @throws HelperException
   */
  public function __construct(Connector|Connect|string $client) {
    parent::__construct($client);

    $this->checkLimit = $client->ENDPOINT->TIMEOUT;
    $this->checkCount = 0;
  }

  /**
   * @param int $count
   *
   * @return $this
   */
  public function checkLimit(int $count = 30): self {
    $this->checkLimit($count);

    return $this;
  }

  /**
   * @param string $blockId
   *
   * @return $this
   */
  public function blockId(string $blockId): self {
    $this->blockId = $blockId;

    return $this;
  }

  /**
   * @return string
   * @throws ApiException
   * @throws HelperException
   */
  public function run(): string {
    if($this->checkCount != $this->checkLimit) {
      $this->result = $this->client->blockMetadata($this->blockId);
      if($this->result instanceof BlockMetadata || $this->result instanceof ResponseMessageMetadata) {
        if(!isset($this->result->ledgerInclusionState)) {
          sleep($this->checkWait);
          $this->checkCount++;

          return $this->run();
        }
        if($this->result->ledgerInclusionState == "included" || $this->result->ledgerInclusionState == "noTransaction") {
          $returnValue = "included";
        }
        else {
          $returnValue = $this->client->getProtocolVersion() == '2' ? $this->conflictReason[$this->result->conflictReason] : $this->conflictReasonV1[$this->result->conflictReason];
        }
      }
      else {
        $returnValue = $this->result->message;
      }
    }
    else {
      $returnValue = "checkTransaction: checkLimit reachted";
    }

    return $returnValue;
  }
}