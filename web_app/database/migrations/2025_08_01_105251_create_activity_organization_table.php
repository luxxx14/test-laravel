<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('activity_organization', function (Blueprint $table) {
        $table->foreignId('activity_id')->constrained()->onDelete('restrict');
        $table->foreignId('organization_id')->constrained()->onDelete('restrict');
        $table->primary(['activity_id', 'organization_id']);
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_organization');
    }
};
