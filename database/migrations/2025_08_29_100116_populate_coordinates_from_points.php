<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update alarm_notification table
        DB::statement("
            UPDATE alarm_notification 
            SET latitude = ST_Y(point), longitude = ST_X(point) 
            WHERE point IS NOT NULL AND latitude IS NULL
        ");
        
        // Update city table
        DB::statement("
            UPDATE city 
            SET latitude = ST_Y(point), longitude = ST_X(point) 
            WHERE point IS NOT NULL AND latitude IS NULL
        ");
        
        // Update position table (most important for GPS tracking)
        DB::statement("
            UPDATE position 
            SET latitude = ST_Y(point), longitude = ST_X(point) 
            WHERE point IS NOT NULL AND latitude IS NULL
        ");
        
        // Update refuel table
        DB::statement("
            UPDATE refuel 
            SET latitude = ST_Y(point), longitude = ST_X(point) 
            WHERE point IS NOT NULL AND latitude IS NULL
        ");
    }

    public function down()
    {
        // No rollback needed as we're just populating data
    }
};