<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * No need to instatiate table,
     * we are using eloquent model naming convention to automatically connecte the model to the database table
     * 
     */


    // Relationships

    /**
      * individual
      * 
      * has one to one relationship
      *
      */

      public function individual(){
        return $this->hasOne('App\Models\Individual');
      }

      /**
       * 
       * 
       */

       public function sacco(){
         return $this->hasManyThough('App\Models\Sacco','App\Model\Individuals');
       }

      //scope

      //pivots
}
