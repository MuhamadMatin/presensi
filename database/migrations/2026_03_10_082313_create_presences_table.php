<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('presences', function (Blueprint $table) {
      $table->string('id_presence', 50)->primary();
      $table->string('location', 255)->nullable();
      $table->string('description', 255)->nullable();
      $table->timestamp('entry');
      $table->timestamp('out')->nullable();
      $table->string('user_id')->index();
      $table->foreign('user_id')->references('id_user')->on('users')->cascadeOnDelete();
      $table->string('status_id')->index();
      $table->foreign('status_id')->references('id_status')->on('statuses')->cascadeOnDelete();
      $table->timestamps();
      $table->string('created_by')->nullable();
      $table->string('updated_by')->nullable();
      $table->softDeletes();
      $table->string('deleted_by')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('presences');
  }
};
