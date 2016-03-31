<?php namespace Gliee\Wphash\Facades;

use Illuminate\Support\Facades\Facade;

class Wphash extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'wphash'; }

}
