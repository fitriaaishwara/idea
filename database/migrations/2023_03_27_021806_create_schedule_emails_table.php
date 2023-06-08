<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_emails', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('attachment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->longText('note')->nullable();
            $table->integer('total_client')->default(0);
            $table->boolean('is_html')->default(0);
            $table->string('subject');
            $table->longText('body');
            $table->char('schedule_status', 1)->default(1)->comment('1: Pending, 2: Success, 3: Failed');
            $table->boolean('status')->default(1);
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
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
        Schema::dropIfExists('schedule_emails');
    }
}
