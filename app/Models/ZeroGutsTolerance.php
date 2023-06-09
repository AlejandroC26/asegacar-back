<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZeroGutsTolerance extends Model
{
    use HasFactory;

    public $table = 'zero_guts_tolerance';

    protected $fillable = [
        'id_master',
        'id_antemortem_daily_record',
        'organ',
        'fecal_matter',
        'resume',
        'hide',
        'hair',
        'hem',
        'abscess',
        'parasite',
        'others',
        'correction',
        'quantity',
        'observations',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function antemortem_daily_record() { return $this->belongsTo(AntemortemDailyRecord::class, 'id_antemortem_daily_record'); }

}
