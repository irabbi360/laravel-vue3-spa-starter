<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_inspector_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('route')->index();
            $table->string('method');
            $table->string('uri');
            $table->unsignedInteger('status_code');
            $table->float('duration_ms')->default(0);
            $table->bigInteger('memory_usage')->default(0);
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('recorded_at')->index();
            $table->timestamps();

            // Indexes for common queries
            $table->index(['route', 'recorded_at']);
            $table->index(['status_code', 'recorded_at']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_inspector_analytics');
    }
};
