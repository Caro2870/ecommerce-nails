<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolio_photos', function (Blueprint $table): void {
            if (! Schema::hasColumn('portfolio_photos', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('categories')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('portfolio_photos', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_featured');
            }
        });

        $categoryId = DB::table('categories')->orderBy('sort_order')->value('id');
        if ($categoryId) {
            DB::table('portfolio_photos')
                ->whereNull('category_id')
                ->update(['category_id' => $categoryId]);
        }
    }

    public function down(): void
    {
        Schema::table('portfolio_photos', function (Blueprint $table): void {
            if (Schema::hasColumn('portfolio_photos', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('portfolio_photos', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
