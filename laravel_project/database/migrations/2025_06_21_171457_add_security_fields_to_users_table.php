<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->integer('login_attempts')->default(0)->after('last_login_ip');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
            $table->boolean('two_factor_enabled')->default(false)->after('locked_until');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->timestamp('password_changed_at')->nullable()->after('two_factor_secret');
            $table->boolean('force_password_change')->default(false)->after('password_changed_at');
            $table->json('security_preferences')->nullable()->after('force_password_change');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_login_at',
                'last_login_ip',
                'login_attempts',
                'locked_until',
                'two_factor_enabled',
                'two_factor_secret',
                'password_changed_at',
                'force_password_change',
                'security_preferences'
            ]);
        });
    }
};
