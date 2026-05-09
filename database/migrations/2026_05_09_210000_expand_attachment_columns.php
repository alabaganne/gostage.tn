<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExpandAttachmentColumns extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE internships MODIFY attachments TEXT NULL');
        DB::statement('ALTER TABLE applications MODIFY attachments TEXT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE internships MODIFY attachments VARCHAR(255) NULL');
        DB::statement('ALTER TABLE applications MODIFY attachments VARCHAR(255) NULL');
    }
}
