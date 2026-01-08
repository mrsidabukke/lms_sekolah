@foreach($modules as $module)
    <a href="{{ route('siswa.modul.show', $module->lessons->first()->id) }}">
        {{ $module->title }}
    </a>
@endforeach
