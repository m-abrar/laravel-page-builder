<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{

    public function show($id)
    {
        $page = Page::findOrFail($id);

        // Remove <body> tags from stored HTML
        $page->html = preg_replace('/<\/?body>/', '', $page->html);

        return view('frontend.page', compact('page'));
    }

}


