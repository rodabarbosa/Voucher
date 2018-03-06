<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpecialOffer;

class SpecialOfferController extends Controller
{
    // just to populate table with some data
    public function createOffers() {
        $discount = 5;
        for ($i = 0; $i < 6; $i++) {
            $offer = new SpecialOffer();
            $offer->name = "Offer" . ($i + 1);
            $offer->discount = $discount;
            $offer->save();

            $discount += 3;
        }
        return $this->listAll();
    }

    public function listAll() {        
        return SpecialOffer::all();
    }

    public function create(Request $request) {
        $offer = SpecialOffer::create($request->json());
        $offer->save();

        return response(['result' => 'saved'], 200);
    }
}
