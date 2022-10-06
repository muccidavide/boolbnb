<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Request $request, Apartment $apartment)
    {  
        $images = Image::where('apartment_id', $apartment->id)->get();
        
        return view('admin.images.index', compact('images', 'apartment'));
    }

   public function destroy(Apartment $apartment, Image $image)
   {
    Storage::delete($image->src);
    $image->delete();
    
    if(count(Image::where('apartment_id', $image->apartment_id)->get()) == 0){
        return redirect()->route('admin.apartment.edit', $apartment->slug)->with('message','All images deleted successfully! 🗑');  
    };
    
    return redirect()->back()->with('message','Image delete successfully!');
   }

    /*TODO - DELETE ALL IMGS  */
}