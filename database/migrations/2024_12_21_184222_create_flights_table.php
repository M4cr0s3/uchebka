<?php

use App\Models\Plane;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_airport_id')
                ->constrained('airports', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('arrival_airport_id')
                ->constrained('airports', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->float('additional_price');
            $table->foreignIdFor(Plane::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->enum('status', ['Готов', 'В полете', 'Прибыл', 'ТО'])->default('Готов');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
