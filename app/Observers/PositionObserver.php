<?php

namespace App\Observers;

use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionObserver
{
    public function saving(Position $position)
    {
        // Auto-populate lat/lng from point geometry
        if ($position->point && (!$position->latitude || !$position->longitude)) {
            $coordinates = DB::selectOne(
                'SELECT ST_X(?) as longitude, ST_Y(?) as latitude',
                [$position->point, $position->point]
            );
            
            if ($coordinates) {
                $position->latitude = round($coordinates->latitude, 5);
                $position->longitude = round($coordinates->longitude, 5);
            }
        }
        
        // Create point from lat/lng if point is missing
        if (!$position->point && $position->latitude && $position->longitude) {
            $position->point = DB::raw("POINT({$position->longitude}, {$position->latitude})");
        }
    }
}