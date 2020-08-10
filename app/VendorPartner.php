<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPartner extends Model
{
    protected $table= "vendor_partner";
    protected $primaryKey = 'vendor_partner_id';
    protected $fillable = ['ngologo','vendor_partner_type_id'];
    protected $attributes = [
        'notes' => " ",
        'address' => " ",
        'regno' => " ",
        'created_by' => " ",
        'updated_by' => " ",
    ];


    /**
     * Get the user that owns the vendorpartnertype.
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    
    public function vendorPartnerType()
    {
        return $this->hasOne('App\VendorPartnerType');
    }
    public function vendorPartnerRep()
    {
        return $this->hasOne('App\vendorPartnerRep');
    }
}
