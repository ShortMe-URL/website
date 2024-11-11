<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ShortUrlController extends Controller
{
    public function click(Request $request, $shortpath)
    {
        $link = Link::where('shortpath', $shortpath)->firstOrFail();

        if ($request->isMethod('get') && $link->password) {
            return view('password-url');
        }

        if ($request->isMethod('post')) {
            $request->validate(['password' => 'required']);

            if (!Hash::check($request->input('password'), $link->password)) {
                return back()->withErrors(['password' => 'Incorrect password.']);
            }
        }

        $link->newClick();
        return redirect()->to($link->tourl);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'shortpath' => 'string|max:255|unique:links',
            'url'       => 'required|url',
            'password'  => 'nullable|string|min:4',
            'delete_at' => 'nullable|string',
        ]);

        $hashedPassword = $request->has('password') && $request->input('password') !== null ? Hash::make($request->input('password')) : null;

        $delete_at =  $request->input('delete_at');
        if ($delete_at === '1day') {
            $delete_at =  Carbon::now()->addDays(1);
        } else if ($delete_at === '3day') {
            $delete_at =  Carbon::now()->addDays(3);
        } else if ($delete_at === '7day') {
            $delete_at =  Carbon::now()->addDays(7);
        } else if ($delete_at === '1month') {
            $delete_at =  Carbon::now()->addMonths(1);
        } else if ($delete_at === '1year') {
            $delete_at =  Carbon::now()->addYears(1);
        } else {
            $delete_at =  Carbon::now()->addDays(1);
        }

        $data = [
            'user_id'   => $user ? $user->id : null,
            'tourl'     => $request->input('url'),
            'password'  => $hashedPassword,
            'delete_at' => $delete_at,
        ];

        if (auth()->user()->premium && $request->has('shortpath') && $request->input('shortpath') !== null) {
            $data['shortpath'] = $request->input('shortpath');
        }

        $created_link = Link::create($data);

        Session::flash('shorturl_created', 'Link created successfully.');
        Session::flash('shorturl_data', $created_link);
        return Redirect::back();
    }
}
