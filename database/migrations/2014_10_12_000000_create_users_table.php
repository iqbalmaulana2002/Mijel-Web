<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->unique();
            $table->string('nama', 50);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('telp', 15)->unique();
            $table->enum('jenkel', ['Laki-laki', 'Perempuan']);
            $table->string('foto');
            $table->string('qr_code', 50)->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->text('alamat');
            $table->enum('level', ['admin', 'petugas', 'anggota']);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('users');
    }
}
