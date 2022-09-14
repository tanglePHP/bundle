<?php namespace tanglePHP\Network\SingleNodesList;

use tanglePHP\Network\Connect;
use tanglePHP\Network\Models\AbstractSingleNodesList;
use Exception;

/**
 * Class user
 *
 * @package      tanglePHP\Network\SingleNodesList
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1148
 */
final class user extends AbstractSingleNodesList {
  /**
   * @param Connect $network
   * @param string  $url
   *
   * @throws Exception
   */
  public function __construct(protected Connect $network, string $url) {
    $this->urls[] = $url;
    parent::__construct($this->network);
  }
}