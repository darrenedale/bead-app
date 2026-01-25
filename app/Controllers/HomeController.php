<?php

namespace App\Controllers;

use Bead\View;
use Bead\Contracts\Web\Request as RequestContract;

/**
 * Home page controller.
 */
class HomeController
{
	/**
	 * Show the app's home page.
	 *
	 * @param RequestContract $request The incoming request.
	 *
	 * @return View The home page view.
	 */
	public function showHomePage(RequestContract $request): View
	{
		return new View("home");
	}
}
