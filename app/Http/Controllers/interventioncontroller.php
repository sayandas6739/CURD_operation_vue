<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class interventioncontroller extends Controller
{
    public function display(){
        return view('intervention');
    }

    public function image(Request $request){
        if($request -> hasFile('photo')){
            $img = Image::make($request->file('photo')->getRealPath());
            $type = 'png';
            $img->brightness($request->get('brightness'))
                ->blur($request->get('blur'))
                ->contrast($request->get('contrast'))
                ->fit($request->get('height'), $request->get('width'))
                ->encode('png');
            $modified_image = 'data:image/' . $type . ';base64,' . base64_encode($img);
            echo json_encode([ $modified_image ]);
        }
    }
}
