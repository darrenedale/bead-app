<?php

namespace App;

use Bead\Core\ConsoleApplication as BaseApplication;
use RuntimeException;
use Bead\Exceptions\ServiceAlreadyBoundException;

/**
 * Base class for the app's console commands.
 */
abstract class ConsoleApplication extends BaseApplication
{
	/**
	 * @throws RuntimeException If an Application instance has already been created.
	 * @throws ServiceAlreadyBoundException If any configured service binder attempts to bind a service to an interface
     * that already has an implementation bound.
	 */
	public function __construct(array $args = [])
	{
		parent::__construct(__DIR__ . "/../", $args);

		$this->setErrorHandler(new ErrorHandler());
	}
}
