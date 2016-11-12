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
            'picture' => $picture,
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

        return view('image/editimage', [
            'pid' => $pid,
            'picture' => $picture,
            'tags' => $tags,
        ]);
    }

    /**
     * Edits the image title.
     *
     * @param Request $request
     * @param $pid
     */
    public function editTitle(Request $request, $pid)
    {
        // Check if title is empty.
        if ($request->input('title') == null) {
//            Session::flash('title_error', 'Error: No title provided.');
//            return Redirect::to('/image/' . $pid . '/edit/');
            $response_array['status'] = 'error';
        } else {
            DB::table('pictures')
                ->where('picture_id', $pid)
                ->update([
                    'picture_title' => $request->input('title')
                ]);
            $response_array['status'] = 'success';
//            Session::flash('title_success', 'Title updated.');
//            return Redirect::to('/image/' . $pid . '/edit/');
        }
        // Send the json.
        print json_encode($response_array);
    }

    /**
     * Edits the image description.
     *
     * @param Request $request
     * @param $pid
     */
    public function editDescription(Request $request, $pid)
    {
        // Check if description is empty.
        if ($request->input('description') == null) {
//            Session::flash('description_error', 'Error: No description provided.');
//            return Redirect::to('/image/' . $pid . '/edit/');
            $response_array['status'] = 'error';
        } else {

            DB::table('pictures')
                ->where('picture_id', $pid)
                ->update([
                    'picture_description' => $request->input('description')
                ]);
            $response_array['status'] = 'success';
//            Session::flash('description_success', 'Description updated.');
//            return Redirect::to('/image/' . $pid . '/edit/');
        }
        // Send the json.
        print json_encode($response_array);
    }

    /**
     * Add tags to an image.
     *
     * @param Request $request
     * @param $pid
     */
    public function addTags(Request $request, $pid)
    {
        // Array that contains the new tags.
        $newTags = [];

        // Check if tag is empty.
        if ($request->input('tags') == null || $request->input('tags') == "") {
            $response_array['status'] = 'error';
        } else {
            // Get tags.
            $tags = explode(',', $request->input('tags'));
            $tags = array_unique(array_map('trim', $tags));

            foreach ($tags as $tag) {
                // Check if the tag is in the database.
                $exists = DB::table('tags')
                    ->where('tag_name', $tag)
                    ->first();

                if (sizeof($exists) == 0) {
                    // Add tag to database.
                    DB::table('tags')->insert([
                        'tag_name' => $tag
                    ]);

                    $exists = DB::table('tags')
                        ->where('tag_name', $tag)
                        ->first();
                }

                // Check if image is already tagged.
                $tagInImage = DB::table('picture_tags')
                    ->where('tag_id', $exists->tag_id)
                    ->where('picture_id', $pid)
                    ->get();

                if (sizeof($tagInImage) == 0) {
                    // Add link image and tag.
                    DB::table('picture_tags')->insert([
                        'picture_id' => $pid,
                        'tag_id' => $exists->tag_id
                    ]);
                    array_push($newTags, $tag);
                }
            }

            $response_array['status'] = 'success';
            $response_array['tags'] = $newTags;
        }
        // Send the json.
        print json_encode($response_array);
    }

    /**
     * Deletes the image.
     *
     * @param $pid
     */
    public function deleteImage($pid)
    {

    }
}