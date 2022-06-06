<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{

    /**
     * No need to instatiate table,
     * we are using eloquent model naming convention to automatically connecte the model to the database table
     * 
     */

    // Relationships

    /**
     * one to one inverse relationship
     * foreign_key in sacco table is individual_id no need to add second constraint
     * primary key in individuals table is id no need to add third constraint
     * hence we can write statement below.
     * 
     */

     public function sacco(){
       return $this->belongsTo('App\Models\Sacco');
     }
     
     /**
      * one to many relationship
      * foreign_key in transactions table is individual_id no need to add second constraint
      * primary key in individuals table is id no need to add third constraint
      *
      */

     public function transaction(){
       return $this->hasMany('App\Models\Transaction');
     }

     // Scopes

     // Pivots
}
