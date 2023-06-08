<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringProjectDetailDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_project_detail_dates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitoring_projects_detail_id')->constrained('monitoring_projects_details');
            $table->foreignUuid('user_id');
            $table->date('revise_date');
            $table->longText('revise_comment');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('monitoring_projects_detail_id', 'monitoring_projects_detail_date_id_foreign')->references('id')->on('monitoring_projects_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_project_detail_dates');
    }
}
