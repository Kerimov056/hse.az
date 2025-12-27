@php
    $tawk = config('services.tawk');
@endphp

@if(!empty($tawk['enabled']) && $tawk['enabled'] && !empty($tawk['property_id']) && !empty($tawk['widget_id']))
    <!-- Tawk.to live chat -->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();

        (function () {
            var s1 = document.createElement("script");
            var s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/{{ $tawk['property_id'] }}/{{ $tawk['widget_id'] }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif
