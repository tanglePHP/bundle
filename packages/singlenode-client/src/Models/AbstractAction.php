<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Network\Connect;
use tanglePHP\SingleNodeClient\Action\checkTransaction;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;

/**
 * Class AbstractAction
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
abstract class AbstractAction {
  protected Connector $client;
  /**
   * @var mixed|null
   */
  public mixed $result = null;
  /**
   * @var BlockList
   */
  public BlockList $blocks;
  /**
   * @var array|bool[]
   */
  protected array $settings = [
    'checkTransaction' => true,
    'addMarketData'    => true,
  ];

  /**
   * @param Connector|Connect|string $client
   *
   * @throws ApiException
   * @throws HelperException
   */
  public function __construct(Connector|Connect|string $client) {
    if(is_string($client)) {
      $client = new Connect($client);
    }
    if($client instanceof Connect) {
      $client = $client->singleNode;
    }
    $this->client = $client;
    $this->blocks = new BlockList($this->client);
  }

  /**
   * @param string|array $key
   * @param bool|null    $val
   *
   * @return $this
   */
  public function setting(string|array $key, bool $val = null): self {
    if(is_array($key)) {
      $this->settings = array_merge($this->settings, $key);
    }
    else {
      $this->settings[$key] = $val;
    }

    return $this;
  }

  /**
   * @param string $blockId
   *
   * @return string
   * @throws ApiException
   * @throws HelperException
   */
  protected function checkTransaction(string $blockId): string {
    return (new checkTransaction($this->client))->blockId($blockId)
                                                ->run();
  }

  /**
   * @return mixed
   */
  abstract public function run(): mixed;

  /**
   * @param int    $code
   * @param string $msg
   * @param array  $metadata
   *
   * @return bool
   * @throws HelperException
   */
  protected function error(int $code, string $msg, array $metadata = []): bool {
    $this->result = TransactionHelper::createError($code, $msg, $metadata);

    return false;
  }

  /**
   * @return mixed
   */
  public function getResult(): mixed {
    if($this->result === null) {
      $this->run();
    }

    return $this->result;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return (string)$this->getResult();
  }
}