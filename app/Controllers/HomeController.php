<?php

namespace App\Controllers;

use Equit\View;
use Equit\Request;

/**
 * Home page controller.
 */
class HomeController
{
	/**
	 * Show the app's home page.
	 *
	 * @param \Equit\Request $request The incoming request.
	 *
	 * @return View The home page view.
	 */
	public function showHomePage(Request $request): View
	{
		return new View("home");
	}
}
