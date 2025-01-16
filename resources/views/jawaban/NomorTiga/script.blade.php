<script>
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('.table-schedule').DataTable({
			language: {
				paginate: {
					next: '<i class="bi bi-arrow-right"></i>',
					previous: '<i class="bi bi-arrow-left"></i>'
				},
				emptyTable: "Data tidak ditemukan",
			}
		});

		// Handle klik tombol edit
		$(document).on('click', '.edit-btn', function(e) {
			e.preventDefault();
			let id = $(this).data('id');
			console.log('Edit button clicked, ID:', id);

			$.ajax({
				url: "{{ route('event.getSelected') }}",
				type: 'POST',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(response) {
					console.log('Success response:', response);
					if (response.status === true && response.data) {
						$('#editForm')[0].reset();

						$('#edit_id').val(response.data.id);
						$('#edit_name').val(response.data.name);
						$('#edit_start').val(response.data.start);
						$('#edit_end').val(response.data.end);

						var editModal = new bootstrap.Modal(document.getElementById('editModal'));
						editModal.show();
					} else {
						console.log('Invalid response:', response);
						alert('Data tidak valid');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error details:', xhr.responseText);
					alert('Terjadi kesalahan saat mengambil data');
				}
			});
		});

		// Handle submit form edit 
		$(document).on('submit', '#editForm', function(e) {
			e.preventDefault();
			console.log('Form submitted');

			let formData = $(this).serialize();
			console.log('Form data:', formData);

			$.ajax({
				url: "{{ route('event.update') }}",
				type: 'POST',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
					$('#editForm button[type="submit"]').attr('disabled', true);
					console.log('Sending update request...');
				},
				success: function(response) {
					console.log('Update response:', response);
					if (response.status === true) {
						console.log('Update successful');
						$('#editModal').modal('hide');
						setTimeout(function() {
							window.location.reload();
						}, 500);
					} else {
						console.log('Update failed:', response.message);
						alert(response.message || 'Gagal menyimpan perubahan');
					}
				},
				error: function(xhr, status, error) {
					console.error('Update error:', xhr.responseText);
					alert('Gagal menyimpan perubahan');
				},
				complete: function() {
					$('#editForm button[type="submit"]').attr('disabled', false);
					console.log('Update request completed');
				}
			});
		});

		// Handle delete 
		$(document).on('click', '.delete-btn', function(e) {
			e.preventDefault();
			let id = $(this).data('id');

			if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
				$.ajax({
					url: "{{ route('event.delete') }}",
					type: 'POST',
					data: {
						id: id
					},
					dataType: 'json',
					success: function(response) {
						if (response.status === true) {
							location.reload();
						} else {
							alert(response.message || 'Gagal menghapus jadwal');
						}
					},
					error: function(xhr, status, error) {
						console.error('Delete error:', error);
						alert('Gagal menghapus jadwal');
					}
				});
			}
		});
	});
</script>