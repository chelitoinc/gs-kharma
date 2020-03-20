<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TABLA EMPRESA
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('director');
            $table->string('domicilio');
            $table->string('estado');
            $table->string('pais');
            $table->integer('cp');
            $table->string('giro');
            $table->string('telefono');
            $table->string('email');
            $table->string('logo');
            $table->timestamps();
        });

        // TABLA CATEGORIA
        Schema::create('categoria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->timestamps();
        });

        // TABLA PROVEEDOR
        Schema::create('proveedor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('sector');
            $table->string('email');
            $table->string('domicilio');
            $table->string('telefono');
            $table->timestamps();
        });

        // TABLA PRODUCTO
        Schema::create('producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('fechaCompra');
            $table->integer('stock');
            $table->decimal('precioC');
            $table->decimal('precioV');
            $table->string('descripcion');
            $table->string('imgProducto');
            $table->timestamps();
        });

        // TABLA PEDIDO
        Schema::create('pedido', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->timestamps();
        });

        // TABLA LISTA
        Schema::create('lista', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('producto');
            $table->integer('cantidad');
            $table->timestamps();
        });

        // TABLA FACTURA
        Schema::create('factura', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cliente');
            $table->integer('cantidad');
            $table->integer('descuento');
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
        
    }
}
