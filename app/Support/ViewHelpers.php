<?php

function include_action($controller, $action, $params = array())
{
  if (is_callable(array($controller, $action))) {
    $c = new $controller ;
    return $c->$action($params) ;
  }
}