<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    
    public function recipient() {
        return $this->belongsTo('App\Recipient', 'recipient_id');
    }

    public function specialOffer() {
        return $this->belongsTo('App\SpecialOffer', 'special_offer_id');
    }
    
    protected $casts = [
        'used' => 'boolean'
    ];
    
    protected $fillable = ['id', 'code', 'recipient_id', 'special_offer_id', 'due_date', 'used', 'used_on'];    
    protected $table = 'voucher';
    public $timestamps = false;
}
