<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Fetch uploads
     * @param NA
     * @return JSON response
     */
    public function index() {
        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
    }

    /**
     * Upload Image
     * @param $request
     * @return JSON response
     */
    public function upload(Request $request) {
        $imagesName = [];
        $response = [];

        $validator = Validator::make($request->all(),
            [
                'uploads' => 'required',
                'uploads.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        );

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "Validation error", "errors" => $validator->errors()]);
        }

        if($request->has('uploads')) {
            foreach($request->file('uploads') as $image) {
                $filename = time().rand(3). '.'.$image->getClientOriginalExtension();
                $image->move('uploads/', $filename);

                Image::create([
                    'image_name' => $filename
                ]);
            }

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        }

        else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }
        return response()->json($response);
    }
}
