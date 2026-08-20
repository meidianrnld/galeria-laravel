<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('satker_id')->nullable()->after('id')->constrained('satkers')->nullOnDelete();
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('role')->default('viewer')->after('email');
            $table->string('jabatan')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('satker_id');
            $table->dropColumn(['username', 'role', 'jabatan']);
        });
    }
};
