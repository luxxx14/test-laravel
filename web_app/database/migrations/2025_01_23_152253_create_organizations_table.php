<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
  /**
   * @return void
   */
  public function up()
  {
    Schema::create('organizations', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->json('phone_numbers')->nullable();
      $table->foreignId('building_id')->constrained()->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('organizations');
  }
}
