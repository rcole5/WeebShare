<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function page($page = 1)
    {
        // Number of pictures displayed on the page.
        $maxPictures = 4;

        // Calculate the offset for the database.
        $offset = $page * $maxPictures - $maxPictures;

        // Get the number pages.
        $pages = ceil(DB::table('pictures')->count() / $maxPictures);

        // Retrieve the pictures to display.
        $pictures = DB::table('pictures')
            ->orderBy('pictures.upload_date', 'DESC')
            ->offset($offset)
            ->limit($maxPictures)
            ->get();

        // Get the tags on the page.
        $tags = [];
        foreach ($pictures as $picture) {
            // Get the picture tags.
            $picture_tags = DB::table('tags')
                ->join('picture_tags', 'tags.tag_id', '=', 'picture_tags.tag_id')
                ->where('picture_tags.picture_id', $picture->picture_id)
                ->get();
            foreach ($picture_tags as $tag) {
                if(!in_array($tag->tag_name, $tags)) {
                    array_push($tags, $tag->tag_name);
                }
            }
        }

        return view('index', [
            'pictures' => $pictures,
            'tags' => $tags,
            'pages' => $pages,
            'current' => $page
        ]);
    }
}
