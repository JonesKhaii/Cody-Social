<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function privacyPolicy()
    {
        return view('pages.policies.privacy');
    }

    public function termsOfService()
    {
        return view('pages.policies.terms');
    }
}
