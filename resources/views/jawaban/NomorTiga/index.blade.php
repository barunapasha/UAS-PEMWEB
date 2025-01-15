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
                <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $event->id }}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $event->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="POST" action="{{ route('event.update') }}">
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
                    <label>Nama</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Start</label>
                    <input type="date" name="start" id="edit_start" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End</label>
                    <input type="date" name="end" id="edit_end" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>