<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
use App\Models\Photo;

class GenreController extends Controller
{
    public function detailGenre (Request $request) {
        $details = Detail::whereHas('photos', function ($query) {
            $query->select('detail_id')
            ->selectRaw('SUM(sum) AS total_id')
            ->groupBy('detail_id')
            ->having('total_id', '=', 1);
        })->where("genre", "=", $request->genre)->get();

        $ans = [];

        foreach ($details as $detail) {
            $photo = Detail::find($detail->id)->photos;

            $ans[] = $photo[0];
        }

        return $ans;
    }

    public function MultipleDetailGenre (Request $request) {
        $details = Detail::whereHas('photos', function ($query) {
            $query->select('detail_id')
            ->selectRaw('SUM(sum) AS total_id')
            ->groupBy('detail_id')
            ->having('total_id', '>', 1);
        })->where("genre", "=", $request->genre)->get();

        $ans = [];

        foreach ($details as $detail) {
            $photo = Detail::find($detail->id)->photos;

            $ans[] = $photo;
        }

        return $ans;
    }
}
