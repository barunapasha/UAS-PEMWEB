<script type="text/javascript">
    $(document).ready(function() {
        // Setup CSRF token untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        const table = $('.table-schedule').DataTable({
            language: {
                paginate: {
                    next: '<i class="bi bi-arrow-right"></i>',
                    previous: '<i class="bi bi-arrow-left"></i>'
                },
                emptyTable: "Data tidak ditemukan",
            },
        });

        // Edit button click handler
        $('.table-schedule').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            
            // Tampilkan loading state
            $(this).prop('disabled', true);
            
            $.ajax({
                url: "{{ route('event.getSelected') }}",
                type: "POST",
                data: { id: id },
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        const event = response.data;
                        $('#edit_id').val(event.id);
                        $('#edit_name').val(event.name);
                        $('#edit_start').val(event.start);
                        $('#edit_end').val(event.end);
                        $('#editModal').modal('show');
                    } else {
                        alert('Data tidak ditemukan');
                    }
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.error || 'Terjadi kesalahan saat mengambil data';
                    console.error('Error:', errorMsg);
                    alert(errorMsg);
                },
                complete: function() {
                    // Hilangkan loading state
                    $('.edit-btn').prop('disabled', false);
                }
            });
        });

        // Handle form submission
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = $(this).serialize();
            const submitBtn = $(this).find('button[type="submit"]');
            
            // Disable submit button
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.error || 'Terjadi kesalahan saat menyimpan data';
                    alert(errorMsg);
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                }
            });
        });

        // Delete button click handler
        $('.table-schedule').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            
            if(confirm('Apakah anda yakin ingin menghapus jadwal ini?')) {
                $(this).prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('event.delete') }}",
                    type: "POST",
                    data: { id: id },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.error || 'Terjadi kesalahan saat menghapus data';
                        alert(errorMsg);
                        $('.delete-btn').prop('disabled', false);
                    }
                });
            }
        });
    });
</script>