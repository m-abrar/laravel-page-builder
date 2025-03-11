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


    public function save(Request $request)
    {
        $html = $request->html;
        $css = $request->css;

        // Handle images (convert base64 to file and save it)
        $html = $this->processImages($html);

        // Save the page
        $page = Page::updateOrCreate(
            ['id' => $request->id],
            ['html' => $html, 'css' => $css]
        );

        return response()->json(['message' => 'Page saved successfully!', 'page' => $page]);
    }

    /**
     * Process Base64 images, save them, and replace with URLs.
     */
    private function processImages($html)
    {
        preg_match_all('/<img[^>]+src="data:image\/(jpeg|png|gif|webp);base64,([^"]+)"/', $html, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $extension = $match[1];
            $base64Data = $match[2];

            // Convert base64 to an image file
            $imageData = base64_decode($base64Data);
            $fileName = uniqid('image_') . '.' . $extension;
            $filePath = 'uploads/pages/' . $fileName;

            // Store image (change storage to 's3' if using AWS S3)
            \Storage::disk('public')->put($filePath, $imageData);

            // Get the public URL of the stored image
            $imageUrl = \Storage::disk('public')->url($filePath);

            // Replace base64 with stored image URL in HTML
            $html = str_replace($match[0], '<img src="' . $imageUrl . '"', $html);
        }

        return $html;
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
