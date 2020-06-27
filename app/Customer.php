<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   // This does the same thing as protected $fillable = ['name', 'email', 'active'];
   // This is to prevent trash data from being injected when mass assigning
    protected $guarded = [];

// For some reason, without this line, the activeOptions and getActiveAttribute methods fails
    protected $attributes = [
        'active' => 1
    ];
    // This is called an accessor. It modifies data when a data request is made to model. It first, fetches the data from
    // database, then modifies the data accroding to the logic specified, then dished it back to the controller requesting
    // the data

    public function getActiveAttribute($attribute)
    {
        return $this->activeOptions()[$attribute];
    // Same as:
    //    return [
    //      1 => 'Active',
    //      0 => 'Inative',
    //    ][$attribute];
    // The reason for the separation of functions is so that we can use the activeOptions function to set the dropdowns in
    // customers form to show the active option properly when editing

    }

    //These are scopes that provide a shortcut for a query that is long but needs to be used multiple times.
    //Its a way to reduce redundancy.
    public function scopeActive($query){
      return $query->where('active', '1');
    }

    public function scopeinactive($query){
      return $query->where('active', '0');
    }

    public function company(){
      return $this->belongsTo(Company::class);
      // Can also be written as $this->belongsTo(Customer::class);
    }

    public function activeOptions(){
      return [
          1 => 'Active',
          0 => 'Inactive',
          2 => 'In-Progress'
      ];
    }

}
