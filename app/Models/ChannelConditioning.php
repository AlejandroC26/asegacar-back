<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelConditioning extends Model
{
    use HasFactory;

    public $table = 'channel_conditioning';

    protected $fillable = [
        'id_master',
        'id_daily_payroll',
        'skin',
        'hair',
        'hematoma',
        'abscess',
        'parasite',
        'other',
        'correction',
        'quantity',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function dailyPayroll() { return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); }
}
