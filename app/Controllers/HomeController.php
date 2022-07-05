<?php

namespace App\Controllers;

use Equit\View;
use Equit\Request;

class HomeController
{
	public function showHomePage(Request $request): View
	{
		return new View("home");
	}
}
