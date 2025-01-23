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
            $table->id(); // ID
            $table->string('name'); // Название организации
            $table->string('phone_numbers')->nullable(); // Номера телефонов (можно хранить как строку или отдельную таблицу для телефонов)
            $table->foreignId('building_id')->constrained()->onDelete('cascade'); // Связь с таблицей зданий
            $table->timestamps(); // Время создания и обновления
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
