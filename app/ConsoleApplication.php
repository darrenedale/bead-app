<?php

namespace App;

use Equit\ConsoleApplication as BaseApplication;
use Exception;

/**
 * Base class for the app's console commands.
 */
class ConsoleApplication extends BaseApplication
{
	use CreatesConfiguredDatabaseConnection;

	/**
	 * The constructor initialises the app's database connection, if configured.
	 * @throws Exception If an Application instance has already been created.
	 */
	public function __construct()
	{
		parent::__construct(__DIR__ . "../");

		$this->setErrorHandler(new ErrorHandler());
		$db = $this->configuredDatabaseConnection();

		if ($db) {
			$this->setDatabase($db);
		}
	}
}
