<?php namespace tanglePHP\Core\Models;
use tanglePHP\IndexerPlugin\V1;

/**
 * Class PluginList
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1648
 */
final class PluginList {
  /**
   * @var AbstractPlugin|V1
   */
  public AbstractPlugin|V1 $Indexer;

  /**
   * @param AbstractPlugin $pluginClass
   * @param string         $propertyName
   *
   * @return void
   */
  public function load(AbstractPlugin $pluginClass, string $propertyName): void {
    if(property_exists($this, $propertyName)) {
      $this->$propertyName = $pluginClass;
    }
  }
}