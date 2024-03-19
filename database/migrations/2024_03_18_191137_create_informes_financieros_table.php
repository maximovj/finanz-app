<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesFinancierosTable extends Migration
{

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 18/03/2024
     * @desc The function creates a table named 'informes_financieros' with various columns including a
     * foreign key 'balanza_id' referencing the 'id' column in the 'balanzas' table.
     * @return void
     */
    public function up()
    {
        Schema::create('informes_financieros', function (Blueprint $table) {
            $table->id();
            // Make foreing key `balanza_id`
            $table->unsignedBigInteger('balanza_id')->nullable();
            $table->foreign('balanza_id')->references('id')
            ->on('balanzas')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->tinyText('no_cuenta')->nullable();
            $table->date('fecha')->default(\Carbon\Carbon::now())->nullable();
            $table->tinyText('descripcion')->nullable();
            $table->tinyText('categoria')->nullable();
            $table->decimal('monto_inicial', 10, 2)->default(0.0)->nullable();
            $table->decimal('monto_final', 10, 2)->default(0.0)->nullable();
            $table->tinyText('etiqueta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 18/03/2024
     * @desc The down() function drops the table 'informes_financieros' from the database.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informes_financieros');
    }
}
