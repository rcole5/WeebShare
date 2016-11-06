<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke()
    {
        // TODO: Create search page.
        return view('search');
    }

    public function index(Request $request)
    {
        if ($request->input('q') == "") {
            // No search field
            // TODO: Handle empty search.
        }

        // TODO: Clean this statement up.
        $pictures = DB::select('
          SELECT DISTINCT results.* FROM 
            (
              SELECT DISTINCT p.* FROM pictures AS p
              INNER JOIN picture_tags
              ON picture_tags.picture_id = p.picture_id
              INNER JOIN (SELECT tags.tag_id, tags.tag_name FROM tags, pictures WHERE (tags.tag_name LIKE ?)) as Q
              ON Q.tag_id = picture_tags.tag_id
              UNION
              SELECT DISTINCT p.* FROM pictures AS p
              INNER JOIN picture_tags
              ON picture_tags.picture_id = p.picture_id
              INNER JOIN (SELECT pictures.picture_id, pictures.picture_title FROM pictures WHERE (pictures.picture_title LIKE ?)) as Q
              ON Q.picture_id = picture_tags.picture_id
            ) results
        ', ['%' . $request->get('q') . '%', '%' . $request->get('q') . '%']);

        return view('search', ['pictures' => $pictures]);
    }
}
