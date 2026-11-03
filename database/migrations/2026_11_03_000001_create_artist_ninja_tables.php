<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('artist_ninja_packages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('artist_ninja_bookings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('package_id')->constrained('artist_ninja_packages');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('invoice_ninja_client_id')->nullable()->index();
            $table->string('quote_id')->nullable()->index();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('status')->default('requested')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('artist_ninja_deliveries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('booking_id')->constrained('artist_ninja_bookings')->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->default('gallery');
            $table->text('url');
            $table->boolean('proofing')->default(false);
            $table->dateTime('visible_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_ninja_deliveries');
        Schema::dropIfExists('artist_ninja_bookings');
        Schema::dropIfExists('artist_ninja_packages');
    }
};
