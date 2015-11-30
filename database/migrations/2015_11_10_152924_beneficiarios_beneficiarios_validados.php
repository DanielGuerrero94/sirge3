<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeneficiariosBeneficiariosValidados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.beneficiarios_validados', function (Blueprint $table) {
            $table->integer('periodo');
            $table->integer('id_smiafiliadosaux');
            $table->string('clavebeneficiario', 16)->primary();
            $table->string('afiapellido', 50)->nullable();
            $table->string('afinombre', 50)->nullable();
            $table->string('afitipodoc', 5)->nullable();
            $table->char('aficlasedoc', 1)->nullable();
            $table->string('afidni', 12);
            $table->char('afisexo', 1)->nullable();
            $table->smallInteger('afitipocategoria');
            $table->date('afifechanac');
            $table->char('afideclaraindigena',1)->nullable();
            $table->integer('afiid_lengua')->nullable();
            $table->integer('afiid_tribu')->nullable();
            $table->string('matipodocumento', 5)->nullable();
            $table->string('manrodocumento', 12)->nullable();
            $table->string('maapellido', 50)->nullable();
            $table->string('manombre', 50)->nullable();
            $table->string('patipodocumento', 5)->nullable();
            $table->string('panrodocumento', 12)->nullable();
            $table->string('paapellido', 50)->nullable();
            $table->string('panombre', 50)->nullable();
            $table->string('otrotipodocumento', 5)->nullable();
            $table->string('otronrodocumento', 12)->nullable();
            $table->string('otroapellido', 50)->nullable();
            $table->string('otronombre', 50)->nullable();
            $table->integer('otrotiporelacion')->nullable();
            $table->date('fechainscripcion')->nullable();
            $table->date('fechaaltaefectiva')->nullable();
            $table->date('fechadiagnosticoembarazo')->nullable();
            $table->integer('semanasembarazo')->nullable();
            $table->date('fechaprobableparto')->nullable();
            $table->date('fechaefectivaparto')->nullable();
            $table->char('activo', 1)->nullable();
            $table->string('afidomcalle', 50)->nullable();
            $table->string('afidomnro', 5)->nullable();
            $table->string('afidommanzana', 3)->nullable();
            $table->string('afidompiso', 3)->nullable();
            $table->string('afidomdepto', 3)->nullable();
            $table->string('afidomentrecalle1', 30)->nullable();
            $table->string('afidomentrecalle2', 30)->nullable();
            $table->string('afidommunicipio', 40)->nullable();
            $table->string('afidomdepartamento', 40)->nullable();
            $table->string('afidomlocalidad', 85)->nullable();
            $table->string('afidomprovincia', 20)->nullable();
            $table->string('afidomcp', 8)->nullable();
            $table->string('afitelefono', 20)->nullable();
            $table->string('lugaratencionhabitual', 80)->nullable();
            $table->date('datosfechaenvio')->nullable();
            $table->date('fechaalta')->nullable();
            $table->smallInteger('pendienteenviar')->nullable();
            $table->char('codigoprovinciaaltadatos', 2)->nullable();
            $table->char('codigouadaltadatos', 3)->nullable();
            $table->char('codigocialtadatos', 5)->nullable();
            $table->smallInteger('motivobaja')->nullable();
            $table->string('mensajebaja', 100)->nullable();
            $table->integer('id_procesobajaautomatica')->nullable();
            $table->smallInteger('pendienteenviaranacion')->nullable();
            $table->integer('id_procesoingresoafiliados');
            $table->integer('id_novedad')->nullable();
            $table->char('tiponovedad', 1)->nullable();
            $table->date('fechanovedad')->nullable();
            $table->date('fechacarga')->nullable();
            $table->string('usuariocarga',10)->nullable();
            $table->smallInteger('aplicadoadefinitiva')->nullable();
            $table->date('fechabajaefectiva')->nullable();
            $table->string('mensajeproceso',100)->nullable();
            $table->string('clavebinaria',70)->nullable();
            $table->string('cuieefectorasignado',6)->nullable();
            $table->string('cuielugaratencionhabitual',6)->nullable();
            $table->string('clavebenefprovocobaja',16)->nullable();
            $table->bigInteger('idpersona')->nullable();
            $table->smallInteger('scorederiesgo')->nullable();
            $table->char('benefalfabetizacion',2)->nullable();
            $table->smallInteger('benefalfabetaniosultimonivel')->nullable();
            $table->char('madrealfabetizacion',2)->nullable();
            $table->smallInteger('madrealfabetaniosultimonivel')->nullable();
            $table->char('padrealfabetizacion',2)->nullable();
            $table->smallInteger('padrealfabetaniosultimonivel')->nullable();
            $table->char('tutoralfabetizacion',2)->nullable();
            $table->smallInteger('tutoralfabetaniosultimonivel')->nullable();
            $table->char('activor',1)->nullable();
            $table->smallInteger('motivobajar')->nullable();
            $table->string('mensajebajar',150)->nullable();
            $table->char('menorconvivecontutor',1)->nullable();
            $table->string('usuariocreacion',15)->nullable();
            $table->date('fechacreacion')->nullable();
            $table->string('email',50)->nullable();
            $table->string('numerocelular',20)->nullable();
            $table->date('fum')->nullable();
            $table->longText('observacionesgenerales')->nullable();
            $table->char('discapacidad',1)->nullable();
            $table->string('afipais',40)->nullable();
            $table->char('embarazoactual',1)->nullable();
            $table->char('ceb',1)->nullable();
            $table->char('cuie',14)->nullable();
            $table->date('fechaultimaprestacion')->nullable();
            $table->string('codigoprestacion',11)->nullable();
            $table->char('devengacapita',1)->nullable();
            $table->integer('devengacantidadcapita');
            $table->char('grupopoblacional',1)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('public.beneficiarios_validados');
    }
}
