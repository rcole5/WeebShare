<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class IsUploader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get image uploader
        $uploader = DB::table('pictures')
            ->where('picture_id', $request->pid)
            ->select('user_id')
            ->first();

        // Check if user is uploader
        if (Auth::id() == $uploader->user_id) {
            return $next($request);
        }

        Session::flash('user_error', 'Only the image uploader can edit the image.');
        return Redirect::to('/image/' . $request->pid);
    }
}
