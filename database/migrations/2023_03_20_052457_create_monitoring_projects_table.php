<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('monitoring_client_id')->constrained('clients')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('date');
            $table->integer('duration');
            $table->longText('note')->nullable();
            $table->boolean('status')->default(1);
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_projects');
    }
}
