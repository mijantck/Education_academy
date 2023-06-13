<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\VideoSections;
use Illuminate\Http\Request;

class VideoSectionsController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'course_id' => 'required',
        ]);

        $section = VideoSections::create($request->all());

        return response()->json(['section' => $section], 201);
    }

    public function show($courseId)
    {
        $videoSections = VideoSections::where('course_id', $courseId)->get();

        return response()->json(['video_sections' => $videoSections]);
    }

    public function intdex()
    {

        $videoSections = VideoSections::with('videos.resources')->get();
        return response()->json(['video_sections' => $videoSections]);
    }

    public function update(Request $request, VideoSections $section)
    {
        $request->validate([
            'name' => 'required',
            'course_id' => 'required',
        ]);

        $section->update($request->all());

        return response()->json(['message' => 'Video section updated successfully']);
    }

    public function destroy(VideoSections $section)
    {
        $section->delete();

        return response()->json(['message' => 'Video section deleted successfully']);
    }


    public function getAllVideoSections()
    {
        $videoSections = VideoSections::all();

        return response()->json(['video_sections' => $videoSections]);
    }
}
