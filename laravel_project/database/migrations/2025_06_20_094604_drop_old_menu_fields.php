<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOldMenuFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Hapus field lama jika ada
            if (Schema::hasColumn('menus', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('menus', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('menus', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('menus', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('menus', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('menus', 'is_available')) {
                $table->dropColumn('is_available');
            }
            if (Schema::hasColumn('menus', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Jika ingin mengembalikan field lama, tambahkan di sini
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(1);
            $table->string('image_url')->nullable();
        });
    }
}
