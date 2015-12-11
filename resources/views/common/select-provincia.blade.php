<select id="provincia" name="provincia" class="form-control">
@foreach ($provincias as $provincia)
	@if (Auth::user()->id_provincia == $provincia->id_provincia)
	<option value="{{ $provincia->id_provincia }}" selected>{{ $provincia->descripcion }}</option>
	@else
	<option value="{{ $provincia->id_provincia }}">{{ $provincia->descripcion }}</option>
	@endif
@endforeach
</select>