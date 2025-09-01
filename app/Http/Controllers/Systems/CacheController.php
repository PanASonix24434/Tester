<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class CacheController extends Controller
{
    public function index()
    {
    	request()->user()->isAuthorize('caches');
    	return view('app.admin.cache.index');
    }

    public function clearAll()
    {
    	Artisan::call('cache:clear');
    	Artisan::call('config:clear');
    	Artisan::call('event:clear');
    	Artisan::call('optimize:clear');
    	Artisan::call('route:clear');
    	Artisan::call('view:clear');
    	return redirect()->back()->with('t_info', __('app.all_caches_cleared'));
    }

    public function clear()
    {
    	Artisan::call('cache:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }

    public function clearConfig()
    {
    	Artisan::call('config:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }

    public function clearEvent()
    {
    	Artisan::call('event:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }

    public function clearBootstrap()
    {
    	Artisan::call('optimize:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }

    public function clearRoute()
    {
    	Artisan::call('route:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }

    public function clearView()
    {
    	Artisan::call('view:clear');
    	return redirect()->back()->with('t_info', __('app.cache_cleared'));
    }
}
