<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationConfig extends Model
{
    use HasFactory;

    protected $table = 'manifesthq_trans_config';

    protected $fillable = [
        'default_locale',sss
        'target_locale',
        'source_locale',
        'license_key',
        'default_domain',
        'license_status', 
        'status',

    ];
}
