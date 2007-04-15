<?php
session_start();
error_reporting(E_ALL);

require_once('HSTemplate' . DIRECTORY_SEPARATOR . 'HSTemplate.class.php');

/* HSTemplate initialization */
$options = array(
                'template_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates',
                'cache_path'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache',
                'debug'         => false,
                );
                
$HSTemplate =& new HSTemplate($options);         
?>