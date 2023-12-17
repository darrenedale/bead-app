<?php

namespace App\Controllers;

use Bead\View;
use Bead\Web\Request;

/**
 * Home page controller.
 */
class HomeController
{
	/**
	 * Show the app's home page.
	 *
	 * @param Request $request The incoming request.
	 *
	 * @return View The home page view.
	 */
	public function showHomePage(Request $request): View
	{
		return new View("home");
	}
}
