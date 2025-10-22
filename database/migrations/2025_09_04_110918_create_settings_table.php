<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->text('about_us')->nullable();
            $table->text('why_us')->nullable();
            $table->text('goal')->nullable();
            $table->text('vision')->nullable();
            $table->bigInteger('tax_percentage')->nullable();
            $table->bigInteger('shipping_fees')->nullable();
            $table->text('welcome_text')->nullable();
            $table->text('home_text')->nullable();
            $table->text('success_text')->nullable();
            $table->text('contact_us_text')->nullable();
            $table->text('terms_text')->nullable();
            $table->integer('pagination')->nullable();
            
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->text('map')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
