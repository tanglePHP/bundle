<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Basic;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Foundry;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\NFT;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Helper\Keys;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;

/**
 * Class InputWithData
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class InputWithData extends AbstractApi {
  use TraitSerializer;

  /**
   * @var Output\Basic|Output\Alias|Output\Foundry|Output\NFT
   */
  public Output\Basic|Output\Alias|Output\Foundry|Output\NFT $consumingOutput;
  /**
   * @var string
   */
  public string $inputIdHex;
  /**
   * @var string
   */
  public string $consumingOutputBytes;

  /**
   * @param Input                   $input
   * @param Keys                    $genesisWalletKeys
   * @param Basic|Alias|Foundry|NFT $consumingOutput
   * @param string                  $outputId
   *
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function __construct(public Input $input, public Keys $genesisWalletKeys, Basic|Alias|Foundry|NFT $consumingOutput, public string $outputId, bool $parsefull = false) {
    $this->consumingOutput      = TransactionHelper::parseConsumingOutput($consumingOutput, $this->outputId, $parsefull);
    $this->consumingOutputBytes = implode('', $this->consumingOutput->serialize());
    //
    $this->inputIdHex = TransactionHelper::createInputIdHex($input);
  }



}