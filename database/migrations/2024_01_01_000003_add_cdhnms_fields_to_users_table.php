<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('public_user_id')->unique()->nullable()->after('id');
            $table->foreignId('institution_id')->nullable()->after('public_user_id')
                ->constrained()->nullOnDelete();
            $table->string('linked_entity_type')->nullable(); // student|teacher|staff|guardian
            $table->unsignedBigInteger('linked_entity_id')->nullable();
            $table->string('account_status')->default('active');
            // active|inactive|suspended|archived|locked|deleted
            $table->boolean('must_change_password')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('institution_id');
            $table->dropColumn([
                'public_user_id', 'linked_entity_type', 'linked_entity_id',
                'account_status', 'must_change_password', 'last_login_at',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
