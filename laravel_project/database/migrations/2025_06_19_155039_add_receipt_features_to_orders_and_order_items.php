<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiptFeaturesToOrdersAndOrderItems extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah kolom ke tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->nullable()->after('notes');
            $table->decimal('tax_percent', 5, 2)->nullable()->default(10)->after('discount');
            $table->decimal('service_charge', 10, 2)->nullable()->after('tax_percent');
            $table->integer('queue_number')->nullable()->after('service_charge');
        });

        // Tambah kolom ke tabel order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom dari tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount', 'tax_percent', 'service_charge', 'queue_number']);
        });

        // Hapus kolom dari tabel order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
}
