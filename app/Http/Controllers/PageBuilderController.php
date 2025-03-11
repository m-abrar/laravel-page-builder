<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;

class PageBuilderController extends Controller
{
    public function edit($id)
    {
        $page = Page::find($id);
    
        if (!$page) {
            abort(404, 'Page not found');
        }
        
        return view('admin.page-builder.edit', compact('page'));

    }
    
    public function save(Request $request, $id)
    {
        $request->validate([
            'html' => 'required|string',
            'css' => 'nullable|string'
        ]);
    
        // Retrieve the page
        $page = Page::find($id);
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
    
        // Process and store images in HTML
        $html = $this->processImagesHTML($page, $request->html);
    
        // Process and store images in CSS
        $css = $this->processImagesCSS($page, $request->css);
    
        // Update the page
        $page->update(['html' => $html, 'css' => $css]);
    
        return response()->json([
            'message' => 'Page saved successfully!',
            'page' => $page
        ]);
    }
    
    

    /**
     * Process Base64 images and save them via Spatie Media Library.
     */
    private function processImagesHTML(Page $page, $html)
    {
        preg_match_all('/<img[^>]+src="data:image\/(jpeg|jpg|png|gif|webp|svg\+xml);base64,([^"]+)"/i', $html, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $extension = $match[1];
            $base64Data = $match[2];

            // Convert Base64 to File
            $imageData = base64_decode($base64Data);
            if (!$imageData) {
                continue;
            }

            $fileName = Str::random(20) . '.' . $extension;
            $tempDir = storage_path('app/temp/');
            $tempFilePath = $tempDir . $fileName;

            // Ensure the temp directory exists
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // Save to temporary file
            if (file_put_contents($tempFilePath, $imageData) === false) {
                continue;
            }

            // Add to Spatie Media Library
            try {
                $media = $page->addMedia($tempFilePath)
                    ->toMediaCollection('pages');
            } catch (\Exception $e) {
                continue;
            }

            // Replace Base64 with Spatie media URL
            $imageUrl = $media->getUrl();
            $html = str_replace($match[0], '<img src="' . $imageUrl . '"', $html);

            // Remove temp file
            if (file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }
        }

        return $html;
    }


    private function processImagesCSS(Page $page, $css)
    {
        // Decode HTML entities first to convert things like &#039; to '
        $css = html_entity_decode($css);
    
        // Match both ' and " inside background-image url()
        preg_match_all('/url\((?:\'|")?data:image\/(jpeg|jpg|png|gif|webp|svg\+xml);base64,([^"\')]+)(?:\'|")?\)/i', $css, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $extension = $match[1];
            $base64Data = $match[2];
    
            // Convert Base64 to File
            $imageData = base64_decode($base64Data);
            if (!$imageData) {
                continue;
            }
    
            $fileName = Str::random(20) . '.' . $extension;
            $tempDir = storage_path('app/temp/');
            $tempFilePath = $tempDir . $fileName;
    
            // Ensure the temp directory exists
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
    
            // Save to temporary file
            if (file_put_contents($tempFilePath, $imageData) === false) {
                continue;
            }
    
            // Add to Spatie Media Library
            try {
                $media = $page->addMedia($tempFilePath)
                    ->toMediaCollection('pages');
            } catch (\Exception $e) {
                continue;
            }
    
            // Replace Base64 with Spatie media URL
            $imageUrl = $media->getUrl();
            $css = str_replace($match[0], 'url("' . $imageUrl . '")', $css);
    
            // Remove temp file
            if (file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }
        }
    
        return $css;
    }
    

    

}
