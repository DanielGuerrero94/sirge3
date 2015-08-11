<select id="menu" name="menu" class="form-control">
@foreach ($menues as $menu)
	@if ($usuario->id_menu == $menu->id_menu)
	<option value="{{ $menu->id_menu }}" selected>{{ $menu->descripcion }}</option>
	@else
	<option value="{{ $menu->id_menu }}">{{ $menu->descripcion }}</option>
	@endif
@endforeach
</select>