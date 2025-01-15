<div class="table-responsive">
    <table class="table table-schedule">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jadwal</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $key => $event)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $event->name }}</td> 
                <td>{{ date('d/m/Y', strtotime($event->start)) }}</td>
                <td>{{ date('d/m/Y', strtotime($event->end)) }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="{{ $event->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $event->id }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST" action="{{ route('event.update') }}">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Jadwal</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_start">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="edit_start" name="start" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_end">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="edit_end" name="end" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>