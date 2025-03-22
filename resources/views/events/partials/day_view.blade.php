<ul class="list-group">
    @forelse ($events as $event)
        <li class="list-group-item">
            <strong>{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</strong>:
            <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
        </li>
    @empty
        <li class="list-group-item">Нет событий на этот день.</li>
    @endforelse
</ul>