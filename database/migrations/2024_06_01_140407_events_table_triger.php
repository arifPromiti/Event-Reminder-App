<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();

        DB::unprepared('
            DROP TRIGGER IF EXISTS `tg_auto_rid_gen`;
            CREATE TRIGGER `tg_auto_rid_gen` BEFORE INSERT ON `events` FOR EACH ROW BEGIN
                DECLARE total_row BIGINT(20);
                DECLARE new_id BIGINT(20);

                SELECT
                    COUNT(*)into total_row
                FROM events;

                IF(total_row > 0)THEN
                    SET new_id = ((SELECT MAX(CONVERT(SUBSTRING_INDEX(IFNULL((SUBSTRING_INDEX(reminder_id,"-",-1)),0),"-",1),UNSIGNED INTEGER)) FROM events)+1);
                ELSE
                    SET new_id = 1;
                END IF;

                SET new.reminder_id = CONCAT("RID-",new_id);

            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tg_auto_rid_gen');
    }
};
