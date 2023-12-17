<?php

namespace App;

use Bead\Exceptions\ServiceAlreadyBoundException;
use Bead\Web\Application as BaseApplication;
use RuntimeException;

/**
 * The app's singleton WebApplication class.
 */
class WebApplication extends BaseApplication
{
    /**
     * @throws RuntimeException If an Application instance has already been created.
     * @throws ServiceAlreadyBoundException If any configured service binder attempts to bind a service to an interface
     * that already has an implementation bound.
     */
	public function __construct()
	{
		parent::__construct(__DIR__ . "/..");
		$this->setErrorHandler(new ErrorHandler());
	}
}
