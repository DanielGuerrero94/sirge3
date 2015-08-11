<select id="area" name="area" class="form-control">
@foreach ($areas as $area)
	@if ($usuario->id_area == $area->id_area)
	<option value="{{ $area->id_area }}" selected>{{ $area->nombre }}</option>
	@else
	<option value="{{ $area->id_area }}">{{ $area->nombre }}</option>
	@endif
@endforeach
</select>