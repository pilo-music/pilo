<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function show()
    {
        return view('admin.pages.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            flash(__("auth.validate"), "danger");
            return redirect()->route('login')
                ->withInput($request->except("password"));
        }


        if (Auth::attempt($request->only(["email", "password"]),$request->get("remember"))) {
            return redirect()->route("admin.index");
        }

        flash(__("auth.failed"), "danger");
        return redirect()->route('login')
            ->withInput($request->except("password"));
    }
}
