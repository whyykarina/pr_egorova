<table class="table table-bordered">
    <thead>
        <tr>
            @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
                <th>{{ $day }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
        @php
        $dateCarbon = \Carbon\Carbon::parse($date);
        $startOfWeek = $dateCarbon->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        @endphp
            @for ($i = 0; $i < 7; $i++)
            @php
            $currentDate = $startOfWeek->copy()->addDays($i);
            @endphp
                <td class="{{ $currentDate->isSameDay(\Carbon\Carbon::now()) ? 'bg-info' : '' }}">
                    {{ $currentDate->format('d') }}
                    @foreach ($events as $event)
                        @if ($event->start_time->isSameDay($currentDate))
                            <div>
                                <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                            </div>
                        @endif
                    @endforeach
                </td>
            @endfor
        </tr>
    </tbody>
</table>