<?php

namespace App\Http\Controllers;

use App\Constant;
use Illuminate\Http\Request;

class ConstantController extends Controller
{
    public function update() {
        $this->validate(request(), [
	        'twitter' => 'nullable|active_url',
	        'facebook' => 'nullable|active_url',
	        'google' => 'nullable|active_url',
	        'linkedin' => 'nullable|active_url'
    	]);
    	$nav = Constant::findOrFail(request()->id);
    	if ($nav->site->user->id != auth()->id()) {
    		return back();
    	}
    	if (request('twitter')) {
	    	$tw = $nav->contents()->where('type', 'twitterLink')->first();
	    	$tw->content = request('twitter');
	    	$tw->save();
    	}
    	if (request('facebook')) {
	    	$fb = $nav->contents()->where('type', 'facebookLink')->first();
	    	$fb->content = request('facebook');
	    	$fb->save();
    	}
    	if (request('google')) {
	    	$gp = $nav->contents()->where('type', 'googleLink')->first();
	    	$gp->content = request('google');
	    	$gp->save();
    	}
    	if (request('linkedin')) {
	    	$li = $nav->contents()->where('type', 'linkedinLink')->first();
	    	$li->content = request('linkedin');
	    	$li->save();
    	}
    	return back();
    }
}
