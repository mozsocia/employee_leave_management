<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category', 'start_date', 'end_date', 'leave_days', 'reason', 'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Enum options
    public static function getCategoryOptions()
    {
        return [
            'vacation' => 'Vacation',
            'sick' => 'Sick',
            'maternity' => 'Maternity',
        ];
    }

    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }
}
