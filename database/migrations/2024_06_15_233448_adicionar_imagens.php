<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('imagem')->nullable();
            $table->text('descricao')->nullable(); // Assuming you want a text field for item description
        });

        Schema::table('restaurantes', function (Blueprint $table) {
            $table->string('imagem')->nullable();
            $table->string('endereco')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('imagem');
            $table->dropColumn('descricao');
        });

        Schema::table('restaurantes', function (Blueprint $table) {
            $table->dropColumn('imagem');
            $table->dropColumn('endereco');
        });
    }
};
