<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE portfolio_photos MODIFY tags TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE portfolio_photos MODIFY tags VARCHAR(255) NULL');
    }
};
