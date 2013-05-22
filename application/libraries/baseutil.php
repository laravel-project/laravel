<?php 

class BaseUtil
{
  public static function collect($collection, $property)
  {
    $values = array();
    foreach ($collection as $item) {
      $values[] = $item->{$property};
    }
    return $values;  
  }
}

?>
