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
        Schema::create('hosting_accounts', function (Blueprint $table) {
            $table->id();

            // ربط بالـ Domain
            $table->foreignId('domain_id')
                ->constrained()
                ->cascadeOnDelete();

            // ربط بالـ Server
            $table->foreignId('server_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('username')->nullable();       // اسم المستخدم في لوحة التحكم
            $table->string('panel')->nullable();          // نوع لوحة التحكم (cPanel, Plesk,..)
            $table->integer('disk_usage')->default(0);    // مساحة الاستضافة المستخدمة (MB)
            $table->integer('bandwidth_usage')->default(0); // استهلاك الباندويث (MB)
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_accounts');
    }
};
