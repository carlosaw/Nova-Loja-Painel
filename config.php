<?php
require 'environment.php';

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/nova_loja_painel/");
	define("BASE_URL_SITE", "http://localhost/nova_loja/");
	$config['dbname'] = 'nova_loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://novaloja.awregulagens.com.br/");
	define("BASE_URL_SITE", "http://localhost/nova_loja/");
	$config['dbname'] = 'awregula_nova_loja';
	$config['host'] = '162.241.2.197';
	$config['dbuser'] = 'awregula';
	$config['dbpass'] = 'H121tRa6lx';
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}