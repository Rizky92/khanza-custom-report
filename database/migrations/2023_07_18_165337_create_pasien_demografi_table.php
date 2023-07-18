<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien_demografi', function (Blueprint $table): void {
            $table->id();
            $table->timestamps($precision = 6);
        });
    }
};
