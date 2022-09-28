<?php namespace tanglePHP\Network\SingleNodesList;

use tanglePHP\Network\Models\AbstractSingleNodesList;

/**
 * Class shimmer_mainnet
 *
 * @package      tanglePHP\Network\SingleNodesList
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.28-1034
 */
final class shimmer_mainnet extends AbstractSingleNodesList {
  /**
   * @var array
   */
  protected array $urls = [
    'https://tanglephp.dlt.builders/',
  ];
}