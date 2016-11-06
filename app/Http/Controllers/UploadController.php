<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{

    /**
     * Display the upload form.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return redirect('upload');
    }

    /**
     * Display the upload form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload');
    }

    /**
     * Upload a new image to the server.
     *
     * @param Request $request .
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Error flag.
        $error = false;

        // Retrieve image.
        $file = array('image' => Input::file('image'));

        // Check if file exists.
        if (!File::exists($file['image'])) {
            Session::flash('image_error', 'Error: No image provided.');
            $error = true;
        } else {
            // Check if image is an image.
            $rules = array('image' => 'required | mimes:jpeg,jpg,gif,png, | max:10240'); //10240
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                // send back to the page with the input data and errors
                Session::flash('image_error', 'Error: ' . dd($validator->errors()->all()));
                $error = true;
            }
        }

        // Check if a title is present.
        if ($request->input('title') == null) {
            Session::flash('title_error', 'Error: No title provided.');
            $error = true;
        }

        // Check if a description is present.
        if ($request->input('description') == null) {
            Session::flash('description_error', 'Error: No description provided.');
            $error = true;
        }

        // Check if tags are present.
        if ($request->input('tags') == null) {
            Session::flash('tags_error', 'Error: No tags entered.');
            $error = true;
        }

        // Redirect back and display errors.
        if ($error)
            return Redirect::to('upload');

        // Generate file name.
        $picName = uniqid();

        // Get file extension.
        $picExt = $file['image']->getClientOriginalExtension();

        // Get tags.
        $tags = explode(',', $request->input('tags'));
        $tags = array_unique(array_map('trim', $tags));

        // Set upload location.
        $path = '../public/img/upload/' . date("Ymd") . '/';
        if (!file_exists($path))
            mkdir($path, 0777, true);

        $publicPath = '/img/upload/' . date("Ymd") . '/';

        // Upload file to server.
        Input::file('image')->move($path, $picName . '.' . $picExt);

        // Update database.
        DB::table('pictures')->insert([
            'user_id' => Auth::id(),
            'picture_title' => $request->input('title'),
            'picture_name' => $picName,
            'picture_extension' => $picExt,
            'picture_location' => $publicPath,
            'picture_description' => $request->input('description')
        ]);

        DB::table('users')
            ->increment('upload_count', 1, ['id' => Auth::id()]);
        $pid = DB::table('pictures')
            ->where('picture_name', $picName)
            ->select('pictures.picture_id')
            ->first();

        /* Check if the tags are already in the database */
        foreach ($tags as $tag) {
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

            DB::table('picture_tags')->insert([
                'picture_id' => $pid->picture_id,
                'tag_id' => $exists->tag_id
            ]);
        }

        return Redirect::to('/image/' . $pid->picture_id);
    }

}
