<select id="grupo" name="grupo" class="form-control">
	<option value="">Seleccione...</option>
@foreach ($sectores as $sector)
	<option value="{{ $sector->id }}">{{ $sector->descripcion }}</option>
@endforeach
</select>