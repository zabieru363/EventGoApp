<?php 
    require_once(realpath(dirname(__FILE__)) . "/lib/BaseController.php");
    require_once(realpath(dirname(__FILE__)) . "/lib/Dispatcher.php");

    $dispatcher = new Dispatcher();
    $dispatcher->dispatch();
?>