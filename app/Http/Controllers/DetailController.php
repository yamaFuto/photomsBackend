<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use Illuminate\Http\Request;
use App\Models\Detial;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = Detail::whereHas('photos', function ($query) {
            $query->select('detail_id')
            ->selectRaw('SUM(sum) AS total_id')
            ->groupBy('detail_id')
            ->having('total_id', '=', 1);
        })->get();

        $ans = [];

        foreach ($details as $detail) {
            $photo = Detail::find($detail->id)->photos;

            $ans[] = $photo;
        }

        return $ans;
    }

    public function multipleIndex() {
        $details = Detail::whereHas('photos', function ($query) {
            $query->select('detail_id')
            ->selectRaw('SUM(sum) AS total_id')
            ->groupBy('detail_id')
            ->having('total_id', '>', 1);
        })->get();

        $ans = [];

        foreach ($details as $detail) {
            $photo = Detail::find($detail->id)->photos;

            $ans[] = $photo;
        }

        return $ans;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //detail保存
        $Detail = new Detail();
        $Detail->name = $request->name;
        $Detail->photoname = $request->photoname;
        $Detail->explanation = $request->explanation;
        $Detail->genre = $request->genre;
        $Detail->created_at = now();
        $Detail->updated_at = now();
        $Detail->save();
        
        //Photo保存
        for($i = 0; $i < 4; $i++) {
            $count = "image" . $i;
            $imageFile = $request->$count;
            if(!is_null($imageFile) && $imageFile->isValid()) {
                //名前指定
                $fileName = uniqid(rand(). '_');
                $extension = $imageFile->extension();
                $fileNameToStore = $fileName. '.' . $extension;

                //resize
                $resizedImage = Image::make($imageFile)->resize(1920,1080)->encode();

                //s3へ格納
                $path = Storage::disk('s3')->put("example/${fileNameToStore}", $resizedImage, 'public');
                $image = Storage::disk('s3')->url($path);

                //pathの成型・保存
                $imageA = substr($image, 0, -1);
                $imageUrl = $imageA . "example/${fileNameToStore}";

                $Photo = new Photo();
                $Photo->detail_id = $Detail->id;
                $Photo->url = $imageUrl;
                $Photo->sum = 1;
                $Photo->created_at = now();
                $Photo->updated_at = now();
                $Photo->save();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Detail $detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detail $detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detail $detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detail $detail)
    {
        //
    }
}
