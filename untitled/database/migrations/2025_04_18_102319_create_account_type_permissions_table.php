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
        Schema::create('account_type_permissions', function (Blueprint $table) {
            $table->foreignId("account_type")->constrained("account_types", "id", "idx_account_type_permissions_account_type")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("permission")->constrained("permissions", "id", "idx_account_type_permissions_permission")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_type_permissions');
    }
};
