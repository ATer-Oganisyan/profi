<?php
/**
 * Vendor: TerOganisyan
 * Author: arsen
 */


require "classes/Controller.php";
require "classes/RequestHandler.php";
require "classes/Displayable.php";
require "classes/UndefinedCustomerException.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_REQUEST['post'] = true;
} else {
    $_REQUEST['post'] = false;
}

$result = \Main\Controller::action(
    new \Main\Controller(new \Main\RequestHandler([])),
    $_REQUEST
);


require "templates/{$result['view']}.php";