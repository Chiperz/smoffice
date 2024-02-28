<?php

namespace App\Traits;
use Illuminate\Http\Request;
use File;
use Image;

trait ImageUploadTraits{
    public function uploadImage(Request $request, $date, $codeItem, $namaItem, $inputName, $path){
        if($request->hasFile($inputName)){

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = $codeItem.'-'.$namaItem.'-'.$date.'.'.$ext;

            // $filePath = $request->image->storeAs('uploads/'.$fileName);
            // $post->image = 'storage/'.$filePath;
            $img = Image::make($image);
            $img->save(public_path($path).$imageName, 50);

            return $path.$imageName;
        }
    }

    public function updateImage(Request $request, $date, $codeItem, $namaItem, $inputName, $path, $oldPath=null){
        if($request->hasFile($inputName)){
            if(File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = $codeItem.'-'.$namaItem.'-'.$date.'.'.$ext;
            
            // $image->move(public_path($path), $imageName);
            $img = Image::make($image);
            $img->save(public_path($path).$imageName, 50);

            return $path.'/'.$imageName;
        }
    }

    public function deleteImage(string $path){
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}