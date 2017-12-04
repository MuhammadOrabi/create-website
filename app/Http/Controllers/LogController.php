<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use App\Site;
use App\Section;
use App\Content;
use App\User;

class LogController extends Controller
{
    public function store()
    {
        $log = Log::create(['type' => request('type'), 'action' => request('action')]);
        if (request('address') !== null) {
            $site = Site::where('address', request('address'))->first();
            $log->sites()->sync($site, false);
            $site->logs()->sync($log, false);
        }
        if (request('section') !== null) {
            $section = Section::find(request('section'));
            $log->sections()->sync($section, false);
            $section->logs()->sync($log, false);
        }
        if (request('content') !== null) {
            $content = Content::find(request('content'));
            $log->contents()->sync($content, false);
            $content->logs()->sync($log, false);
        }
        if (request('user') !== null) {
            $user = User::find(request('user'));
            $log->users()->sync($user, false);
            $user->logs()->sync($log, false);
        }

        return response()->json($log);
    }
}
