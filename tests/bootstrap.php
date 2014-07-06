<?php
/**
 * @todo so ugle
*/
define('C5_EXECUTE', 1);
define('C5_ENVIRONMENT_ONLY', 1);
define('DIR_BASE', dirname(__FILE__) . '/core/concrete5/web');
define('REDIRECT_TO_BASE_URL', false);
define('CONCRETE_5_DATA_TEST_DIR', dirname(__FILE__));
if (!getenv('TRAVIS')) {
	include_once(dirname(__FILE__) . '/test_config.php');
} else {
	include_once(dirname(__FILE__) . '/test_config_travis.php');
}
$pdo = new PDO('mysql:host=' . $config['db-server'] . ';dbname=' . $config['db-database'], $config['db-username'], $config['db-password']);
$pdo->exec('SET unique_checks=0;');
$pdo->exec('SET foreign_key_checks=0;');
$pdo->exec(file_get_contents(dirname(__FILE__) . '/fixtures/database.sql'));
$pdo->exec('SET unique_checks=1;');
$pdo->exec('SET foreign_key_checks=1;');
$config = null;
require_once(dirname(__FILE__) . '/core/concrete5/web/concrete/dispatcher.php');
require(ADODB_DIR . '/adodb-lib.inc.php');
$dataPackage = new DataPackage;
$dataPackage->registerAutoloaders();
$pdo->exec(file_get_contents(dirname(__FILE__) . '/fixtures/schema.sql'));
$pdo = null;
require_once(dirname(__FILE__) . '/data_database_test_case.php');
