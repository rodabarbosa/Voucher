<?php

namespace App\Http\Controllers;

use App\Recipient;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    // just to populate table with some data
    public function createRecipient() {
        for ($i = 0; $i < 10; $i++) {
            $recipient = new Recipient();
            $recipient->name = "recipient" . ($i+1);
            $recipient->email = "{$recipient->name}@test.com";
            $recipient->save();
        }

        return $this->listAll();
    }

    public function listAll() {        
        return Recipient::all();
    }

    public function create(Request $request) {
        $count = Recipient::where('email', 'like', $request->json('email'))->count();
        if ($count > 0) {
            return response(['error' => 409, 'message' => 'email already exists'], 409);
        }

        try {
            $recipient = Recipient::create($request->json());
            $recipient->save();
            return response(['result' => 'saved'], 200);
        } catch (\Exception $ex) {
            return response(['error' => 500, 'message' => $ex->getMessage()], 500);
        }
    }


}
