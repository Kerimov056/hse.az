{{-- resources/views/partials/chat-switcher.blade.php --}}
@php
    use Carbon\Carbon;

    $now = Carbon::now('Asia/Baku');

    $isWeekday = $now->isWeekday(); // 1–5

    $start = $now->copy()->setTime(10, 30);
    $end   = $now->copy()->setTime(17, 0);

    $inBusinessHours = $now->between($start, $end);

    $showTawk = $isWeekday && $inBusinessHours;
@endphp

@if($showTawk)
    {{-- Həftə içi 10:30–17:00 → Tawk canlı çat --}}
    @include('partials.tawk')
@else
    {{-- Qalan bütün vaxtlar → sənin Laravel chat-widget komponentin --}}
    <x-chat-widget label="Mesaj göndərin" title="Bizə yazın" />
@endif
