<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'notif_email')) {
                $table->boolean('notif_email')->default(false)->after('photo');
            }
            if (!Schema::hasColumn('users', 'notif_promo')) {
                $table->boolean('notif_promo')->default(false)->after('notif_email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'photo', 'notif_email', 'notif_promo']);
        });
    }
}; 