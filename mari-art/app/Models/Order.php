<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'house_type',
        'roof_type',
        'foundation_type',
        'finishing_material',
        'windows_type',
        'heating_type',
        'sewage_type',
        'construction_time',
        'additional_services',
        'total_cost',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'additional_services' => 'array',
        'total_cost' => 'decimal:2',
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
