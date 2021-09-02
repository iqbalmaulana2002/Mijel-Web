<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedekahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedekah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('tanggal');
            $table->enum('status', ['Selesai', 'Sedang Dijemput', 'Pending']);
            $table->unsignedInteger('jumlah')->default(0);
            $table->unsignedInteger('harga')->default(0);
            $table->enum('keterangan', ['Tunai', 'Tabung']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sedekah');
    }
}
