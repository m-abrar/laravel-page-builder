<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; // Ensure you have a Page model

class PageBuilderController extends Controller
{
    public function index()
    {
        return view('admin.page-builder');
    }

    public function save(Request $request)
    {
        $page = Page::updateOrCreate(
            ['id' => $request->id], 
            ['html' => $request->html, 'css' => $request->css]
        );

        return response()->json(['message' => 'Page saved successfully!', 'page' => $page]);
    }

    public function load($id)
    {
        $page = Page::find($id);
        return response()->json($page);
    }
}
