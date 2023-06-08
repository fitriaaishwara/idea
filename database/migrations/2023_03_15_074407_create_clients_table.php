<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->char('regency_id')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->char('scope_1')->nullable();
            $table->char('scope_2')->nullable();
            $table->char('scope_3')->nullable();
            $table->string('service')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_position')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('last_followup_at')->nullable();
            $table->boolean('is_win')->default(0);
            $table->boolean('status')->default(1);
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
