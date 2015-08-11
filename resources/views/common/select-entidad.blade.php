<select id="entidad" name="entidad" class="form-control">
@foreach ($entidades as $entidad)
	@if ($usuario->id_entidad == $entidad->id)
	<option value="{{ $entidad->id }}" selected>{{ $entidad->descripcion }}</option>
	@else
	<option value="{{ $entidad->id }}">{{ $entidad->descripcion }}</option>
	@endif
@endforeach
</select>