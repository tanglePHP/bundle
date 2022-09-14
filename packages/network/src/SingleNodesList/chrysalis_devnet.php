<?php namespace tanglePHP\Network\SingleNodesList;

use tanglePHP\Network\Models\AbstractSingleNodesList;

/**
 * Class chrysalis_devnet
 *
 * @package      tanglePHP\Network\SingleNodesList
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class chrysalis_devnet extends AbstractSingleNodesList {
  /**
   * @var string[]
   */
  protected array $urls = [
    'https://api.lb-0.h.chrysalis-devnet.iota.cafe/',
  ];
}