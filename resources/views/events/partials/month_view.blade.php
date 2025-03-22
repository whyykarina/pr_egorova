<table class="table table-bordered">
    <thead>
        <tr>
            @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
                <th>{{ $day }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @php
    $dateCarbon = \Carbon\Carbon::parse($date);
    $startOfMonth = $dateCarbon->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::MONDAY);
    $endOfMonth = $dateCarbon->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SUNDAY);
    $currentDate = $startOfMonth->copy();

    @endphp
    @while ($currentDate <= $endOfMonth)
        @if ($currentDate->dayOfWeek == \Carbon\Carbon::MONDAY)
            <tr>
        @endif

        <td class="{{ $currentDate->isSameDay(\Carbon\Carbon::now()) ? 'bg-info' : '' }} {{ $currentDate->month != $dateCarbon->month ? 'text-muted' : '' }}">
            {{ $currentDate->day }}
            @foreach ($events as $event)
                @if ($event->start_time->isSameDay($currentDate))
                    <div>
                        <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                    </div>
                @endif
            @endforeach
        </td>

        @if ($currentDate->dayOfWeek == \Carbon\Carbon::SUNDAY)
            </tr>
        @endif
        @php
        $currentDate->addDay();
        @endphp
    @endwhile

    </tbody>
</table>