<?php namespace tanglePHP\Core\Models;
/**
 * Interface InterfaceSerializer
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1649
 */
interface InterfaceSerializer {
  /**
   * @return array
   */
  public function serialize(): array;

  /**
   * @return string
   */
  public function serializeToHash(): string;

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeInt(string $value): string;

  /**
   * @param string $value
   *
   * @return mixed
   */
  static public function serializeUInt16(string $value): string;

  /**
   * @param string $value
   *
   * @return mixed
   */
  static public function serializeBigInt(string $value): string;

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeFixedHex(string $value): string;
}