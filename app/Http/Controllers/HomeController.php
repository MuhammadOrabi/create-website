<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth')->except(['index']);
	}

	public function index() {
		return view('home-page.index');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dashboard() {
		$sites = auth()->user()->sites;
		if (!$sites->first()) {
			return redirect()->route('site.create'); 
		}
		return view('home-page.dashboard', compact('sites'));
	}

}
