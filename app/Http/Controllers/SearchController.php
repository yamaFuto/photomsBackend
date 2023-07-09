<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        $details = DB::table("details");
        // whereHas('photos', function ($query) {
        //     $query->select('detail_id')
        //     ->selectRaw('SUM(sum) AS total_id')
        //     ->groupBy('detail_id')
        //     ->having('total_id', '=', 1);
        // });

        if ($search) {

            $spaceConversion = mb_convert_kana($search, "s");

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $details->where('name', 'like', '%'.$search.'%')->orWhere('photoname', 'like', '%'.$search.'%');
            }

            $SearchDetails = $details->get();

            $ans = [];

            foreach ($SearchDetails as $detail) {
                $photo = Detail::find($detail->id)->photos;

                if (count($photo) == 1) {
                    $ans[] = $photo[0];
                }
            }

        } else {

            $SearchDetails = $details->get();

            $ans = [];

            foreach ($SearchDetails as $detail) {
                $photo = Detail::find($detail->id)->photos;

                if (count($photo) == 1) {
                    $ans[] = $photo[0];
                }
            }
        }

        return $ans;
    }

    public function MultipleSearch(Request $request) {
        $search = $request->search;
        $details = DB::table("details");
        // whereHas('photos', function ($query) {
        //     $query->select('detail_id')
        //     ->selectRaw('SUM(sum) AS total_id')
        //     ->groupBy('detail_id')
        //     ->having('total_id', '=', 1);
        // });

        if ($search) {

            $spaceConversion = mb_convert_kana($search, "s");

            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $details->where('name', 'like', '%'.$search.'%')->orWhere('photoname', 'like', '%'.$search.'%');
            }

            $SearchDetails = $details->get();

            $ans = [];

            foreach ($SearchDetails as $detail) {
                $photo = Detail::find($detail->id)->photos;

                if (count($photo) > 1) {
                    $ans[] = $photo;
                }
            }

        } else {

            $SearchDetails = $details->get();

            $ans = [];

            foreach ($SearchDetails as $detail) {
                $photo = Detail::find($detail->id)->photos;

                if (count($photo) > 1) {
                    $ans[] = $photo;
                }
            }
        }

        return $ans;
    }
}
