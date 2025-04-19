<?php

use App\Core\ListAccountTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Factories\AccountTypeFactory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->tinyText("system_name");
            $table->tinyText("nice_name");
        });

        foreach(ListAccountTypes::get() as $value) {
            AccountTypeFactory::new([
                "id"=>$value["id"],
                "system_name"=>$value["system_name"],
                "nice_name"=>$value["nice_name"],
            ])->create();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
