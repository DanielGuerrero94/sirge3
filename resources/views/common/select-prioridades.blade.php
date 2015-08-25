<select id="prioridades" name="prioridad" class="form-control">
@foreach ($prioridades as $prioridad)
	<option value="{{ $prioridad->id }}">{{ $prioridad->descripcion }}</option>
@endforeach
</select>