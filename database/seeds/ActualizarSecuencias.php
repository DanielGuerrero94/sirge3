<?php

use Illuminate\Database\Seeder;
class ActualizarSecuencias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SELECT SETVAL('efectores.addendas_id_seq', COALESCE(MAX(id), 1) ) FROM efectores.addendas;");
		DB::statement("SELECT SETVAL('sistema.areas_id_area_seq', COALESCE(MAX(id_area), 1) ) FROM sistema.areas;");
		DB::statement("SELECT SETVAL('consultas.automaticas_id_consulta_seq', COALESCE(MAX(id_consulta), 1) ) FROM consultas.automaticas;");
		DB::statement("SELECT SETVAL('ddjj.backup_id_impresion_seq', COALESCE(MAX(id_impresion), 1) ) FROM ddjj.backup;");
		DB::statement("SELECT SETVAL('beneficiarios.bajas_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.bajas;");
		DB::statement("SELECT SETVAL('beneficiarios.categorias_nacer_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.categorias_nacer;");
		DB::statement("SELECT SETVAL('efectores.categorias_ppac_id_categoria_seq', COALESCE(MAX(id_categoria), 1) ) FROM efectores.categorias_ppac;");
		DB::statement("SELECT SETVAL('beneficiarios.ceb_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.ceb;");
		DB::statement("SELECT SETVAL('sistema.clases_documento_id_seq', COALESCE(MAX(id), 1) ) FROM sistema.clases_documento;");
		DB::statement("SELECT SETVAL('comprobantes.comprobantes_id_seq', COALESCE(MAX(id), 1) ) FROM comprobantes.comprobantes;");
		DB::statement("SELECT SETVAL('efectores.compromiso_gestion_id_compromiso_seq', COALESCE(MAX(id_compromiso), 1) ) FROM efectores.compromiso_gestion;");
		DB::statement("SELECT SETVAL('beneficiarios.contacto_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.contacto;");
		DB::statement("SELECT SETVAL('efectores.convenio_administrativo_id_convenio_seq', COALESCE(MAX(id_convenio), 1) ) FROM efectores.convenio_administrativo;");
		DB::statement("SELECT SETVAL('chat.conversaciones_id_seq', COALESCE(MAX(id), 1) ) FROM chat.conversaciones;");
		DB::statement("SELECT SETVAL('geo.departamentos_id_seq', COALESCE(MAX(id), 1) ) FROM geo.departamentos;");
		DB::statement("SELECT SETVAL('ddjj.doiu9_id_impresion_seq', COALESCE(MAX(id_impresion), 1) ) FROM ddjj.doiu9;");
		DB::statement("SELECT SETVAL('efectores.efectores_addendas_id_seq', COALESCE(MAX(id), 1) ) FROM efectores.efectores_addendas;");
		DB::statement("SELECT SETVAL('efectores.efectores_id_efector_seq', COALESCE(MAX(id_efector), 1) ) FROM efectores.efectores;");
		DB::statement("SELECT SETVAL('efectores.efectores_neonatales_id_seq', COALESCE(MAX(id), 1) ) FROM efectores.efectores_neonatales;");
		DB::statement("SELECT SETVAL('efectores.efectores_obstetricos_id_seq', COALESCE(MAX(id), 1) ) FROM efectores.efectores_obstetricos;");
		DB::statement("SELECT SETVAL('efectores.email_id_email_seq', COALESCE(MAX(id_email), 1) ) FROM efectores.email;");
		DB::statement("SELECT SETVAL('beneficiarios.embarazos_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.embarazos;");
		DB::statement("SELECT SETVAL('sistema.entidades_id_seq', COALESCE(MAX(id), 1) ) FROM sistema.entidades;");
		DB::statement("SELECT SETVAL('geo.entidades_id_seq', COALESCE(MAX(id), 1) ) FROM geo.entidades;");		
		DB::statement("SELECT SETVAL('sistema.estados_id_estado_seq', COALESCE(MAX(id_estado), 1) ) FROM sistema.estados;");				
		DB::statement("SELECT SETVAL('solicitudes.estados_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.estados;");
		DB::statement("SELECT SETVAL('consultas.estandar_id_consulta_seq', COALESCE(MAX(id_consulta), 1) ) FROM consultas.estandar;");
		DB::statement("SELECT SETVAL('fondos.fondos_id_seq', COALESCE(MAX(id), 1) ) FROM fondos.fondos;");
		DB::statement("SELECT SETVAL('graficos.graficos_id_seq', COALESCE(MAX(id), 1) ) FROM graficos.graficos;");
		DB::statement("SELECT SETVAL('solicitudes.grupos_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.grupos;");
		DB::statement("SELECT SETVAL('indicadores.indicadores_medica_id_seq', COALESCE(MAX(id), 1) ) FROM indicadores.indicadores_medica;");
		DB::statement("SELECT SETVAL('indicadores.indicadores_medica_rangos_id_seq', COALESCE(MAX(id), 1) ) FROM indicadores.indicadores_medica_rangos;");
		DB::statement("SELECT SETVAL('indicadores.indicadores_priorizados_id_seq', COALESCE(MAX(id), 1) ) FROM indicadores.indicadores_priorizados;");
		DB::statement("SELECT SETVAL('geo.localidades_id_seq', COALESCE(MAX(id), 1) ) FROM geo.localidades;");
		DB::statement("SELECT SETVAL('logs.logins_id_seq', COALESCE(MAX(id_inicio), 1) ) FROM logs.logins;");
		DB::statement("SELECT SETVAL('sistema.lotes_lote_seq', COALESCE(MAX(lote), 1) ) FROM sistema.lotes;");
		DB::statement("SELECT SETVAL('chat.mensajes_id_seq', COALESCE(MAX(id), 1) ) FROM chat.mensajes;");
		DB::statement("SELECT SETVAL('sistema.menues_id_menu_seq', COALESCE(MAX(id_menu), 1) ) FROM sistema.menues;");
		DB::statement("SELECT SETVAL('indicadores.metas_efectores_priorizados_id_seq', COALESCE(MAX(id), 1) ) FROM indicadores.metas_efectores_priorizados;");
		DB::statement("SELECT SETVAL('sistema.modulos_id_modulo_seq', COALESCE(MAX(id_modulo), 1) ) FROM sistema.modulos;");
		DB::statement("SELECT SETVAL('sistema.modulos_menu_id_relacion_seq', COALESCE(MAX(id_relacion), 1) ) FROM sistema.modulos_menu;");
		DB::statement("SELECT SETVAL('puco.obras_sociales_id_osp_seq', COALESCE(MAX(id_osp), 1) ) FROM puco.obras_sociales;");
		DB::statement("SELECT SETVAL('efectores.operaciones_id_operacion_seq', COALESCE(MAX(id_operacion), 1) ) FROM efectores.operaciones;");
		DB::statement("SELECT SETVAL('solicitudes.operadores_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.operadores;");
		DB::statement("SELECT SETVAL('sistema.padrones_id_padron_seq', COALESCE(MAX(id_padron), 1) ) FROM sistema.padrones;");
		DB::statement("SELECT SETVAL('sistema.parametros_id_parametro_seq', COALESCE(MAX(id_parametro), 1) ) FROM sistema.parametros;");
		DB::statement("SELECT SETVAL('beneficiarios.periodos_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.periodos;");
		DB::statement("SELECT SETVAL('prestaciones.prestaciones_id_seq', COALESCE(MAX(id), 1) ) FROM prestaciones.prestaciones;");
		DB::statement("SELECT SETVAL('solicitudes.prioridades_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.prioridades;");
		DB::statement("SELECT SETVAL('logs.rechazos_id_seq', COALESCE(MAX(id), 1) ) FROM logs.rechazos;");
		DB::statement("SELECT SETVAL('prestaciones.rechazos_migracion_id_seq', COALESCE(MAX(id), 1) ) FROM prestaciones.rechazos_migracion;");
		DB::statement("SELECT SETVAL('efectores.referentes_id_referente_seq', COALESCE(MAX(id_referente), 1) ) FROM efectores.referentes;");
		DB::statement("SELECT SETVAL('geo.regiones_id_region_seq', COALESCE(MAX(id_region), 1) ) FROM geo.regiones;");
		DB::statement("SELECT SETVAL('sistema.regiones_id_region_seq', COALESCE(MAX(id_region), 1) ) FROM sistema.regiones;");
		DB::statement("SELECT SETVAL('mobile.reporte_problemas_id_problema_seq', COALESCE(MAX(id_problema), 1) ) FROM mobile.reporte_problemas;");
		DB::statement("SELECT SETVAL('beneficiarios.score_id_seq', COALESCE(MAX(id), 1) ) FROM beneficiarios.score;");
		DB::statement("SELECT SETVAL('sistema.sexos_id_sexo_seq', COALESCE(MAX(id_sexo), 1) ) FROM sistema.sexos;");
		DB::statement("SELECT SETVAL('ddjj.sirge_id_impresion_seq', COALESCE(MAX(id_impresion), 1) ) FROM ddjj.sirge;");
		DB::statement("SELECT SETVAL('solicitudes.solicitudes_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.solicitudes;");
		DB::statement("SELECT SETVAL('puco.sss_temp_id_osp_prueba_seq', COALESCE(MAX(id_osp_prueba), 1) ) FROM puco.sss_temp;");
		DB::statement("SELECT SETVAL('sistema.subidas_id_subida_seq', COALESCE(MAX(id_subida), 1) ) FROM sistema.subidas;");
		DB::statement("SELECT SETVAL('sistema.sugerencias_id_sugerencia_seq', COALESCE(MAX(id_sugerencia), 1) ) FROM sistema.sugerencias;");
		DB::statement("SELECT SETVAL('efectores.telefonos_id_telefono_seq', COALESCE(MAX(id_telefono), 1) ) FROM efectores.telefonos;");
		DB::statement("SELECT SETVAL('efectores.tipo_categorizacion_id_categorizacion_seq', COALESCE(MAX(id_categorizacion), 1) ) FROM efectores.tipo_categorizacion;");
		DB::statement("SELECT SETVAL('efectores.tipo_dependencia_administrati_id_dependencia_administrativa_seq', COALESCE(MAX(id_dependencia_administrativa), 1) ) FROM efectores.tipo_dependencia_administrativa;");
		DB::statement("SELECT SETVAL('sistema.tipo_documento_id_tipo_documento_seq', COALESCE(MAX(id_tipo_documento), 1) ) FROM sistema.tipo_documento;");
		DB::statement("SELECT SETVAL('efectores.tipo_efector_id_tipo_efector_seq', COALESCE(MAX(id_tipo_efector), 1) ) FROM efectores.tipo_efector;");
		DB::statement("SELECT SETVAL('efectores.tipo_estado_id_estado_seq', COALESCE(MAX(id_estado), 1) ) FROM efectores.tipo_estado;");
		DB::statement("SELECT SETVAL('mobile.tipo_familiar_id_tipo_familiar_seq', COALESCE(MAX(id_tipo_familiar), 1) ) FROM mobile.tipo_familiar;");
		DB::statement("SELECT SETVAL('efectores.tipo_operacion_id_operacion_seq', COALESCE(MAX(id_operacion), 1) ) FROM efectores.tipo_operacion;");
		DB::statement("SELECT SETVAL('solicitudes.tipo_solicitud_id_seq', COALESCE(MAX(id), 1) ) FROM solicitudes.tipo_solicitud;");
		DB::statement("SELECT SETVAL('efectores.tipo_telefono_id_tipo_telefono_seq', COALESCE(MAX(id_tipo_telefono), 1) ) FROM efectores.tipo_telefono;");
		DB::statement("SELECT SETVAL('sistema.usuarios_id_usuario_seq', COALESCE(MAX(id_usuario), 1) ) FROM sistema.usuarios;");
		DB::statement("SELECT SETVAL('mobile.usuarios_id_usuario_seq', COALESCE(MAX(id_usuario), 1) ) FROM mobile.usuarios;");
    }
}