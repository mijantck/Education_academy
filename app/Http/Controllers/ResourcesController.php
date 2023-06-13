<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ResourcesController extends Controller
{
    //

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'video_id' => 'required',
            ]);
    
            $requestData = $request->all();
    
            if ($request->hasFile('file')) {
                $request->validate([
                    'file' => 'required',
                ]);
    
                $file = $request->file('file');
                //$filename = $file->getClientOriginalName();
                // $file->move('uploads/videos/resource/', $filename);

                // $requestData['type'] = 'file';
                // $requestData['url'] = 'uploads/videos/resource/' . $filename;


                $filePath = $file->store('videos/resource', 'public');

                $requestData['type'] = 'file';
                $requestData['url'] = $filePath;

            }else{
                $requestData['url'] = $request->input('url');
                $requestData['type'] = 'url';
            }
    

            if (empty($requestData['url'])) {

                return response()->json(['message' => 'The URL field is required.'], 422);
            }
            
            $resource = Resources::create($requestData);
    
            return response()->json(['resource' => $resource], 201);
            
        } catch (QueryException $e) {
            $errorCode = $e->getCode();
            
            if ($errorCode === '23000') {
                $errorMessage = 'Cannot add or update the resource due to a foreign key constraint violation.';
            } else {
                $errorMessage = 'An error occurred while processing the request.';
            }
    
            return response()->json(['error' => $errorMessage], 500);
        }
    

        
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'video_id' => 'required',
            'type' => 'required|in:url,file',
        ]);

        $resource = Resources::findOrFail($id);

        $requestData = $request->all();

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:mp4,mov,avi',
            ]);

            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->move('uploads/videos', $filename);

            $requestData['url'] = 'uploads/videos/' . $filename;
        }else {
            // If file is not uploaded, set url to null or provide a default value
            $requestData['url'] = null; // or set to a default value
        }

        $resource->update($requestData);

        return response()->json(['resource' => $resource], 200);
    }

    public function destroy(Resources $resource)
    {
        $resource->delete();

        return response()->json(['message' => 'Resource deleted']);
    }
}
