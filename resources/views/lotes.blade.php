<div class="container">
    @foreach ($users as $user)
        {{ $user->lote }}
    @endforeach
</div>

{!! $users->render() !!}