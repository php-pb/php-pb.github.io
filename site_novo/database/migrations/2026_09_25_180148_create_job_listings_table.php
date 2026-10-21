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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('company');
            $table->string('company_logo')->nullable();
            $table->string('location')->nullable();
            $table->string('work_mode')->default('presencial');
            $table->string('employment_type')->default('clt');
            $table->string('seniority')->default('pleno');
            $table->string('salary_range')->nullable();
            $table->text('description')->nullable();
            $table->string('external_url');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
