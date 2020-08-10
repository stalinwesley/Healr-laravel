<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPartnerRep extends Model
{
    protected $table= "vendor_partner_rep";
    protected $primaryKey = 'vendor_partner_rep_id';
    protected $fillable = ['ngologo','notes'];
    protected $attributes = [
        'notes' => " ",
        'created_by' => " ",
        'updated_by' => " ",
    ];


    /**
     * Get the user that owns the vendorpartnertype.
     */
    public function VendorPartner()
    {
        return $this->belongsTo('App\VendorPartner','vendor_partner_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    
}
