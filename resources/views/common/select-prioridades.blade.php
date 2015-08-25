<select id="prioridades" name="prioridades" class="form-control">
@foreach ($prioridades as $prioridad)
	<option value="{{ $prioridad->id }}">{{ $prioridad->descripcion }}</option>
@endforeach
</select>