<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringProjectsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_projects_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('monitoring_project_id')->nullable()->constrained('monitoring_projects')->onDelete('cascade');
            $table->string('temporary_id')->nullable();
            $table->string('activity');
            $table->integer('order');
            $table->longText('description')->nullable();
            $table->integer('percentage');
            $table->string('pic')->nullable();
            $table->longText('comment')->nullable();
            $table->boolean('is_done')->default(0);
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
        Schema::dropIfExists('monitoring_projects_details');
    }
}
