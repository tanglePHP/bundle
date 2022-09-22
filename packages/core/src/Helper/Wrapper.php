<?php namespace tanglePHP\Core\Helper;
/**
 * Class Wrapper
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.21-2037
 */
final class Wrapper {
  /**
   * @param string $string
   *
   * @return string
   */
  static public function path_normalize(string $string): string {
    $parts    = [];
    $string   = str_replace('\\', '/', $string);
    $prefix   = '';
    $segments = explode("://", $string);
    if(count($segments) == 2) {
      $prefix = $segments[0] . "://";
      $string = $segments[1];
    }
    $string   = preg_replace('/\/+/', '/', $string);
    $segments = explode('/', $string);
    foreach($segments as $segment) {
      if($segment != '.') {
        $_check = array_pop($parts);
        if(is_null($_check)) {
          $parts[] = $segment;
        }
        else if($segment == '..') {
          if($_check == '..') {
            $parts[] = $_check;
          }
          if($_check == '..' || $_check == '') {
            $parts[] = $segment;
          }
        }
        else {
          $parts[] = $_check;
          $parts[] = $segment;
        }
      }
    }

    return count($parts) > 0 ? $prefix . implode('/', $parts) : '';
  }
}