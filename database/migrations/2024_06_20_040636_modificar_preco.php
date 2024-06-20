<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('preco', 10, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('preco', 8, 2)->change();
        });
    }
};
