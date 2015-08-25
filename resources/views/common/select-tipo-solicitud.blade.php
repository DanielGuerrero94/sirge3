<label for="tipo-solicitud">Seleccione el tipo de requerimiento</label>
<select id="tipo-solicitud" name="tipo_solicitud" class="form-control">
	<option value="">Seleccione ...</option>
@foreach ($tipos as $tipo)
	<option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
@endforeach
</select>