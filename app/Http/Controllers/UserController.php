<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 20/11/2016
 * Time: 2:21 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __invoke()
    {

    }

    /**
     * Display the user information.
     *
     * @param $uid - User ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($uid)
    {
        // Get User Info.
        $user = DB::table('users')
            ->where('id', $uid)
            ->first();

        // Recent Uploads/
        $ruploads = DB::table('pictures')
            ->where('user_id', $uid)
            ->orderby('upload_date', 'DESC')
            ->limit(5)
            ->get();

        // Recent Comments.

        return view('user/user', [
            'user' => $user,
            'uploads' => $ruploads
        ]);
    }

    /**
     * Display no user found page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noUser()
    {
        return view('nouser');
    }
}