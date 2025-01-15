<script type="text/javascript">
    $(document).ready(function() {
        $('.table-schedule').DataTable({
            language: {
                paginate: {
                    next: '<i class="bi bi-arrow-right"></i>',
                    previous: '<i class="bi bi-arrow-left"></i>'
                },
                emptyTable: "Data tidak ditemukan",
            },
        });

        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');
            
            $.ajax({
                url: "{{ route('event.getSelected') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#edit_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_start').val(response.start);
                    $('#edit_end').val(response.end);
                    $('#editModal').modal('show');
                }
            });
        });


        $('.delete-btn').on('click', function() {
            let id = $(this).data('id');
            
            if(confirm('Apakah anda yakin ingin menghapus jadwal ini?')) {
                $.ajax({
                    url: "{{ route('event.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>