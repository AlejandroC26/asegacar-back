<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Person extends Model
{
    use HasFactory;

    public $table = 'persons';
    
    protected $fillable = [
        'fullname',
        'document',
        'expedition_city',
        'adress',
        'phone',
        'signature',
        'authorization',
    ];

    public function onGetSignature() {
        if($this->signature) {
            $sPath = storage_path('app/public/signatures/'.$this->signature);
            $sFileContent = File::get($sPath);
            $sMime = mime_content_type($sPath);
            $sBase64 = base64_encode($sFileContent);
            return 'data:' . $sMime . ';base64,' . $sBase64;
        } else {
            return null;
        }
    }
}
