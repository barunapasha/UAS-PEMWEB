<script type="text/javascript">
    $(document).ready(function() {
        function loadEvents() {
            $.ajax({
                method: "GET",
                url: "{{ route('event.get-json') }}",
                success: function(response) {
                    // Update events di kalender
                    calendar.removeAllEvents();
                    calendar.addEventSource(response);
                },
                error: function(error) {
                    console.error("Error loading events:", error);
                }
            });
        }

        // Load events 
        loadEvents();

        $('.table-schedule').on('calendar-update', function() {
            loadEvents();
        });

        if (typeof window.calendar !== 'undefined') {
            window.calendar.on('eventAdd', loadEvents);
            window.calendar.on('eventChange', loadEvents);
            window.calendar.on('eventRemove', loadEvents);
        }
    });
</script>