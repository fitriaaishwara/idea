<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('attachment_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('no_document');
            $table->date('date');
            $table->integer('revisi');
            $table->string('description')->nullable();
            $table->char('extension', 5);
            $table->bigInteger('size')->default(0);
            $table->Integer('download')->default(0);
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
        Schema::dropIfExists('document_archives');
    }
}
