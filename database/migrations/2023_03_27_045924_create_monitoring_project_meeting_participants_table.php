<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringProjectMeetingParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_project_meeting_participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitoring_project_meeting_id')->nullable();
            $table->string('temporary_id')->nullable();
            $table->string('name');
            $table->string('role');
            $table->boolean('status')->default(1);
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('monitoring_project_meeting_id', 'monitoring_project_meeting_id_foreign_participant')->references('id')->on('monitoring_project_meetings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_project_meeting_participants');
    }
}
