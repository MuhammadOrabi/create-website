<?php

namespace App\Http\Controllers;

use App\Constant;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Blogs\BlogsHelper;

class ConstantController extends Controller
{
    public function update()
    {
        if (request()->ajax()) {
            $constant = Constant::findOrFail(request()->id);
            $site = auth()->user()->sites()->where('address', $constant->site->address)->firstOrFail();
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $data = WebsitesHelper::finder($site, null, 'constant-update', request()->all(), $constant);
                return response()->json($data);
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($site, null, 'constant-update', request()->all(), $constant);
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($site, null, 'constant-update', request()->all(), $constant);
                return response()->json($data);
            }
        } else {
        }
    }

    public function show()
    {
        if (request()->ajax()) {
            $constant = Constant::findOrFail(request()->id);
            $site = $constant->site;
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $data = WebsitesHelper::finder($site, null, 'constant-get', null, $constant);
                return response()->json($data);
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($site, null, 'constant-get', null, $constant);
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($site, null, 'constant-get', null, $constant);
                return response()->json($data);
            }
        }
        abort(404);
    }
}
