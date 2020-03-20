<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // RELACIONES DE LAS TABLAS
        Schema::table('empresa', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Relación de categoria con usuarios
        Schema::table('categoria', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('proveedor', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Relación de producto a categoria
        Schema::table('producto', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('proveedor_id');
            
            $table->foreign('categoria_id')->references('id')->on('categoria')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedor')->onDelete('cascade');
        });

        // Relación pedido con usuarios
        Schema::table('pedido', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('proveedor_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedor')->onDelete('cascade');
        });

        // Relación lista con pedido
        Schema::table('lista', function (Blueprint $table) {
            $table->unsignedBigInteger('pedido_id');

            $table->foreign('pedido_id')->references('id')->on('pedido')->onDelete('cascade');
        });

        // Relación factura con usuarios
        Schema::table('factura', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('producto_id');

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade');
        });

        // INSERT TO TABLE USERS
        DB::table('users')->insert([
            'name'      => 'Angel',
            'apellidos' => 'Paredes Torres',
            'domicilio' => 'Anfel',
            'cp'        => '62780',
            'ine'       => 'kndlfkdnspfknpi',
            'telefono'  => '1111111111',
            'email'     => 'chelo@gmail.com',
            'password'  => '$2y$10$Y4AZHex4.7735W.7rWZ8U.6Rzzkh75HRQC0krAiK.Oo...',
            'imagen'    => 'default.jpg'
        ]);

            DB::table('empresa')->insert([
                'nombre'    => 'KH Solutions',
                'director'  => 'Angel Paredes Torres',
                'domicilio' => 'Calle de las flores',
                'estado'    => 'Morelos',
                'pais'    => 'Mexico',
                'cp'        => '62780',
                'giro'      => '1111111111',
                'telefono'  => '7773478422',
                'email'     => 'chelo@gmail.com',
                'user_id'   => 1
            ]);

            DB::table('categoria')->insert([
                'nombre'  => 'Galletas',
                'user_id' => 1
            ]);

            DB::table('proveedor')->insert([
                'nombre'    => 'Angel Paredes Torres',
                'sector'    => 'Comercio de productos',
                'email'     => 'chelo@gmail.com',
                'domicilio' => 'calle de las flores 2',
                'telefono'  => '777343478422',
                'user_id'   => 1 
            ]);
            




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    /* public function down()
    {
       
    } */
}
