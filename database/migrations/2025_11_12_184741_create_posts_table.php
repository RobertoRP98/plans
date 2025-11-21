<?php

use App\Models\Category;
use App\Models\Municipio;
use App\Models\Plan;
use App\Models\State;
use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->date('start')->nullable();;
            $table->date('end')->nullable();;
            $table->timestamps();
            $table->string('slug');
            $table->integer('views')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->enum('status', ['pending', 'active', 'expired'])->default('pending');

            $table->string('phone');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(State::class)->constrained();
            $table->foreignIdFor(Municipio::class)->constrained();
            $table->foreignIdFor(Plan::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
