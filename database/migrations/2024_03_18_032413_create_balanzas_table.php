<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanzasTable extends Migration
{

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 17/03/2024
     * @desc The function creates a database table named 'balanzas' with various columns and default values
     * for some fields.
     * @return void
     */
    public function up()
    {
        Schema::create('balanzas', function (Blueprint $table) {
            $table->id();
            $table->string("titulo")->default('Sin titulo');
            $table->string("descripcion")->default('Sin descripción');
            $table->string('src_balanza')->default('na');
            $table->string('periodo')->default('na')->nullable();
            $table->year('anio_1era')->default(date('Y')); // Default value for the current year
            $table->tinyText('mes_1era')->nullable(); // Default value (Enero)
            $table->year('anio_2da')->default(date('Y')); // Default value for the current year
            $table->tinyText('mes_2da')->nullable(); // Default value (Enero)
            $table->timestamps();
        });
    }

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 17/03/2024
     * @desc The down() function in PHP drops the 'balanzas' table from the database schema.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balanzas');
    }
}
