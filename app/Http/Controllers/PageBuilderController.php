<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageBuilderController extends Controller
{
    public function edit($id)
    {
        return view('admin.page-builder.edit', compact('id'));
    }

    public function save(Request $request, $id = null)
    {
        $page = Page::updateOrCreate(
            ['id' => $id ?? $request->id],
            ['html' => $request->html, 'css' => $request->css]
        );

        return response()->json(['message' => 'Page saved successfully!', 'page' => $page]);
    }

    public function load($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404); // ✅ Handle missing page
        }

        return response()->json($page);
    }
}
