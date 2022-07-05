<?php

namespace App;

use Equit\ConsoleApplication as BaseApplication;

class ConsoleApplication extends BaseApplication
{
	use CreatesConfiguredDatabaseConnection;

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
