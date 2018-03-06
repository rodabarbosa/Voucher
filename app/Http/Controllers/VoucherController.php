<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoucherCode;
use App\Recipient;
use App\SpecialOffer;

class VoucherController extends Controller
{    
    private function generateCode() {
        // Will always start with a Letter followed by a number
        $code = chr(rand(65,90)) . intval( "0" . rand(1,9));

        // Define no of digits to randonly generate between numbers and characters 
        $remainingDigitsSize = 6;

        // from digit 3 forward will randonly be between number or characters 
        for ($i = 0; $i < $remainingDigitsSize; $i++) {        
             $code .= (rand(1,100)%2 == 0) ? intval( "0" . rand(1,9)) : chr(rand(65,90));
        }
        return $code;
    }

    // just to populate table with some data
    public function createVoucherData() {        
        for ($i = 0; $i < 100; $i++) {
            if ($i < 20) {
                $daysToExpire = 5;                
            } else if ($i < 40) {
                $daysToExpire = 10;
            } else if ($i < 60) {
                $daysToExpire = 15;
            } else if ($i < 80) {
                $daysToExpire = 20;            
            } else if ($i < 90) {
                $daysToExpire = 10;
            } else {
                $daysToExpire = 20;
            } 

            $voucher = new VoucherCode();
            $voucher->code = $this->generateCode();
            $voucher->recipient_id = intval( "0" . rand(1,10));
            $voucher->special_offer_id = intval( "0" . rand(1,6));
            if ($i < 80) {
                $voucher->due_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + intval( "0" . rand(1,$daysToExpire)), date('Y')));
            } else {
                $voucher->due_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - intval( "0" . rand(1,$daysToExpire)), date('Y')));
            }
            
            $voucher->save();
        }
        return $this->listAll();
    }

    public function listAll() {        
        return VoucherCode::all();
    }

    public function listValid() {
        return VoucherCode::where('used', false)
        ->where('due_date', '>', date('Y-m-d'))
            ->get();
    }

    public function listUsed() {
        return VoucherCode::where('used', true)            
            ->get();
    }

    public function listExpired() {
        return VoucherCode::where('used', false)
            ->where('due_date', '<', date('Y-m-d'))
            ->get();
    }

    public function listByEmail($email) {
        return VoucherCode::whereHas('recipient', function($query) use ($request) {
            $query->where('email', $request->json('email'));
        })
        ->with(['recipient'])        
        ->where('used', false)
        ->get();;        
    }

    public function get($code) {        
        return VoucherCode::where('code', 'like', $code)
            ->firstOrFail();
    }

    public function validateVoucher(Request $request) {        
        $voucher = VoucherCode::whereHas('recipient', function($query) use ($request) {
            $query->where('email', $request->json('email'));
        })
        ->with(['recipient', 'specialoffer'])
        ->where('code', $request->json('voucher'))
        ->first();
        
        if ($voucher){
            if ($voucher->used) {
                return response(['error' => 400, 'message' => 'voucher already been used'], 400);
            }

            if ($voucher->due_date > date('Y-m-d')) {
                return response(['error' => 400, 'message' => 'voucher has expired'], 400);
            }

            $voucher->used = true;
            $voucher->used_on = date('Y-m-d');
            $voucher->save();

            return ['discount' => $voucher->specialoffer->discount];
        } 
        
        return response(['error' => 404, 'message' => 'not found'], 404);
    }
    
    public function createVoucher(Request $request) {
        $recipients = Recipient::all();
        $offer = SpecialOffer::where('id', $request->json('offer'))->first();
        if (!$offer) {
            return response(['error' => 400, 'message' => 'special offer not found'], 400);
        }

        $current_date = date('Y-m-d');
        $date = strtotime($request->json('date'));
        if ($date < $current_date) {
            return response(['error' => 400, 'message' => 'Date must be at least one day over'], 400);
        }

        foreach ($recipients as $recipient) {
            $voucher = new VoucherCode();
            $voucher->code = $this->generateCode();
            $voucher->recipient_id = $recipient->id;
            $voucher->special_offer_id = $offer->id;
            $voucher->due_date = $request->json('expired_date');
            
            $voucher->save();
            return response(['result' => 'saved'], 200);
        }
    }
}
