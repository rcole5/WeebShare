<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ImageController extends Controller
{

    public function __invoke()
    {
        return redirect('home');
    }

    /*
     * Displays image to user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pid)
    {
        /* Database Queries */
        // Get the specified picture.
        $picture = DB::table('pictures')
            ->where('picture_id', $pid)
            ->first();

        // Get the uer that uploaded the picture.
        $user = DB::table('users')
            ->where('id', $picture->user_id)
            ->first();

        // Get the picture tags.
        $tags = DB::table('tags')
            ->join('picture_tags', 'tags.tag_id', '=', 'picture_tags.tag_id')
            ->where('picture_tags.picture_id', $picture->picture_id)
            ->get();

        // Get the comments for the picture.
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.picture_id', $pid)
            ->select('comments.*', 'users.name', 'users.comment_count')
            ->orderBy('comment_date', 'desc')
            ->get();

        // Display page.
        // TODO: Reduce amount of variables passed.
        return view('image/image', [
            'url' => $picture->picture_location . $picture->picture_name . '.' . $picture->picture_extension,
            'title' => $picture->picture_title,
            'upload_date' => $picture->upload_date,
            'description' => $picture->picture_description,
            'username' => $user->name,
            'upload_count' => $user->upload_count,
            'tags' => $tags,
            'comments' => $comments,
            'pid' => $pid
        ]);

    }

    /*
     * Displays no image error page.
     *
     * @return \Illuminate\Http\Response
     */
    public function noImage()
    {
        return view('image/noimage');
    }

    /*
     * Adds comment to image.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        /* Check if comment is empty */
        if ($request->input('comment') == null) {
            Session::flash('comment_error', 'Error: No comment provided.');
            return Redirect::back();
        }

        /* Check if the picture id variable has been modified */
        try {
            $pid = Crypt::decrypt($request->input('pid'));
        } catch (DecryptException $e) {
            Session::flash('comment_error', 'Error: Hidden variable has been modified. This activity will be logged.');
            return Redirect::back();
        }

        /* Insert comment into database. */
        DB::table('comments')->insert([
           'user_id' => Auth::id(),
            'picture_id' => $pid,
            'comment_text' => $request->input('comment')
        ]);

        /* Increment comment count. */
        DB::table('users')
            ->increment('comment_count', 1, ['id' => Auth::id()]);

        /* Redirect back to image */
        return Redirect::back();
    }

    /*
     * Edits current image.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($pid)
    {
        // TODO: Create edit function.
        return Redirect::to('/home');
    }
}