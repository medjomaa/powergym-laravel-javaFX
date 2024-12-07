<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'type', 'start_date', 'end_date', 'user_id', 'coach_id', 'room_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Add a method to check for conflicts
    public static function hasConflict($startDate, $endDate, $coachId, $roomId, $eventId = null)
    {
        $query = self::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
        })
        ->where(function ($query) use ($coachId, $roomId) {
            $query->where('coach_id', $coachId)
                  ->orWhere('room_id', $roomId);
        });

        if ($eventId) {
            $query->where('id', '!=', $eventId);
        }

        return $query->exists();
    }
}
