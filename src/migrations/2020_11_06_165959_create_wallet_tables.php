<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount');
            $table->tinyInteger('type');
            $table->tinyInteger('method');
            $table->tinyInteger('gateway')->nullable();
            $table->text('description')->nullable();
            $table->string('callback_url')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('rbac_role_user');
        Schema::dropIfExists('rbac_permission_role');
        Schema::dropIfExists('rbac_permissions');
        Schema::dropIfExists('rbac_permission_groups');
        Schema::dropIfExists('rbac_roles');
    }
}
