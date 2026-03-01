<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function customers()
    {
        $customers = User::where('is_admin', false)->latest()->paginate(20);
        return view('admin.customers', compact('customers'));
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function discounts()
    {
        return view('admin.discounts');
    }

    public function content()
    {
        return view('admin.content');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
