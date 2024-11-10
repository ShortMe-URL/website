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
    public function click($shortpath)
    {
        $link = Link::where('shortpath', $shortpath)->first();

        if (!$link) {
            abort(404);
        }

        if ($link->password !== null) {
            view('Enter Password');
            return;
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
            'password'  => 'nullable|string|min:8',
            'premium'   => 'nullable|boolean',
            'delete_at' => 'nullable|string',
        ]);

        $hashedPassword = $request->has('password') ? Hash::make($request->input('password')) : null;

        $delete_at =  $request->input('delete_at');
        if ($delete_at === '1day') {
            $delete_at =  Carbon::now()->addDays(1);
        } else if ($delete_at === '3day') {
            $delete_at =  Carbon::now()->addDays(3);
        } else if ($delete_at === '7day') {
            $delete_at =  Carbon::now()->addDays(7);
        } else {
            $delete_at =  Carbon::now()->addDays(1);
        }
        $created_link = Link::create([
            'user_id'   => $user ? $user->id : null,
            'tourl'     => $request->input('url'),
            'password ' => $hashedPassword,
            'premium'   => $request->input('premium') ? true : false,
            'delete_at' => $delete_at,
        ]);

        Session::flash('shorturl_created', 'Link created successfully.');
        Session::flash('shorturl_data', $created_link);
        return Redirect::back();
    }
}
