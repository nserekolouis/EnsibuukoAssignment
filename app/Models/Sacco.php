<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sacco extends Model
{

    /**
     * No need to instatiate table,
     * we are using eloquent model naming convention to automatically connecte the model to the database table
     * 
     */

     
    //Relationships

    /**
     * has a one to many relationship
     *
     */

     public function individual(){
       return $this->hasMany('App\Models\Individual');
     }

     /**
      * get all transactions
      * foreign keys are well specified
      * id is the primary incrementing key in all tables
      *
      */

      public function transaction(){
        return $this->hasManyThrough('App\Models\Transaction','App\Models\Individual');
      }

      //scopes

      //pivots
}
