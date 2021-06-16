<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee_statistics extends Model {

    protected $table = 'fee_statistics';

    protected $primaryKey = 'fee_id';

    public $timestamps = false;

}
