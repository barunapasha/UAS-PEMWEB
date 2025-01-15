<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    let calendar;

    $(document).ready(function(){
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                right   : 'prev,next',
                center  : 'title', 
                left    : null,
            },
            locale: 'id',
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '{{ route("event.get-json") }}',
                    type: 'GET',
                    success: function(response) {
                        successCallback(response);
                    },
                    error: function(error) {
                        failureCallback(error);
                    }
                });
            }
        });
        calendar.render();
    });
</script>