<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OverlayImage;

class OverlayImageController extends Controller
{
    public function upload(Request $request)
    {
        $business_id = session()->get('user.business_id');
        // Validate the request
        
        $id = $request->input('overlay_id');

        // Check if $id is present to determine store or update operation
        if ($id === null) {
            // Handle image upload
            $overlayImage = new OverlayImage();
            $overlayImage->position = $request->position;
            $overlayImage->business_id = $business_id;
            $overlayImage->event_id = $request->event_id;
            $overlayImage->enabled = $request->has('enabled') ? true : false;

            if ($request->hasFile('overlay_image')) {
                $image = $request->file('overlay_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $overlayImage->overlay_image_path = 'uploads/' . $imageName;
            }

            $overlayImage->save();
        }else {
            $overlayImage = OverlayImage::findOrFail($id);
            $overlayImage->position = $request->position;
            $overlayImage->business_id = $business_id;
            $overlayImage->event_id = $request->event_id;
            $overlayImage->enabled = $request->has('enabled') ? true : false;

            if ($request->hasFile('overlay_image')) {
                $image = $request->file('overlay_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $overlayImage->overlay_image_path = 'uploads/' . $imageName;
            }
            $overlayImage->update();
        }

        // Redirect back with success message or handle as needed
        $message = 'Overlay image settings saved successfully.';
        return redirect()->back()->with('status', ['success'=>1,'msg'=>$message]);
    }
}
