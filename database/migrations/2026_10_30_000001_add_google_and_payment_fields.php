<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('google_id');
            $table->string('password')->nullable()->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code', 30)->nullable()->after('id');
            $table->enum('pickup_session', ['istirahat_1', 'istirahat_2'])->default('istirahat_1')->after('kiosk_id');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid')->after('total_price');
            $table->string('payment_type', 50)->nullable()->after('payment_status');
            $table->string('snap_token')->nullable()->after('payment_type');
            $table->text('notes')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'pickup_session', 'payment_status', 'payment_type', 'snap_token', 'notes']);
        });
    }
};
