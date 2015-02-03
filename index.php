<?php
require_once 'includes/config.php';
require_once 'includes/classes/view.php';
require_once 'router.php';

$view = new View($content_tpl);
if ($checker) {
	$view->checker = 1;
} else {
	$view->checker = 0;
}
$view->setHeader('templates/header.phtml');
$view->setFooter('templates/footer.phtml');
echo $view;
