<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'section_id' => 'required',
            'course_id' => 'required',
            'videosType' => 'required|in:video,resource',
            'haveResource' => 'required|in:true,false',
        ]);

        $requestData = $request->all();

        // return response()->json(['video' => $requestData], 201);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required', // Adjust the allowed file types as needed
            ]);

            // Handle file upload logic here
            $file = $request->file('file');
            //$filename = $file->getClientOriginalName();
            // $file->move('uploads/videos', $filename);
            // $requestData['url'] = 'uploads/videos/' . $filename;
            // $requestData['type'] = 'file';

             $filePath = $file->store('videos', 'public');
             $requestData['type'] = 'file';
             $requestData['url'] = $filePath;

        } elseif ($request->has('url')) {
            $request->validate([
                'url' => 'required|url',
            ]);

            $requestData['type'] = 'url';
        }

        $video = Videos::create($requestData);

        return response()->json(['video' => $video], 201);
    }

    public function index(Courses $course)
    {
        $videos = Videos::where('course_id', $course->id)->get();

        return response()->json(['videos' => $videos]);
    }

    public function update(Request $request, Videos $video)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required_if:type,url',
            'file' => 'required_if:type,upload|mimes:mp4,mov,avi', // Adjust the allowed file types as needed
            'section_id' => 'required',
            'videosType' => 'required',
            'haveResource' => 'required',
        ]);

        // Handle file update logic here if necessary
        // ...

        $video->update($request->all());

        return response()->json(['video' => $video]);
    }

    public function destroy(Videos $video)
    {
        // Delete the associated resources
        $video->resources()->delete();

        // Delete the video
        $video->delete();

        return response()->json(['message' => 'Video and associated resources deleted successfully']);
    }
}
