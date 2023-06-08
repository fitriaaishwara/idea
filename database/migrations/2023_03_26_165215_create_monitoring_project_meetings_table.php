<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringProjectMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_project_meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitoring_project_id')->constrained('monitoring_projects');
            $table->string('agenda');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('location');
            $table->string('mom');
            $table->text('note')->nullable();
            $table->boolean('status')->default(1);
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('monitoring_project_id', 'monitoring_project_id_foreign_meeting')->references('id')->on('monitoring_projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_project_meetings');
    }
}
