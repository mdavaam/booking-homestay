<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Kamars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>

    @include('layouts.sidebar-top')

    <!-- Main Content -->
    <div class="content" style="margin-left: 260px; padding: 20px;">
        <div class="row">
            <!-- Room Management Table -->
            <div class="col-md-12">
                <div class="card mt-1 shadow-sm">
                       <div class="card-body">
                        @if (session('success'))
                        <div id="alertSuccess" class="alert alert-success">
                        {{ session('success') }}
                        </div>
                        @endif
                        <h5 class="card-title mb-3">Kamar Tersedia</h5>
                        <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        + Kamar
                        </button>
                        </div>

                        <div class="mb-3">
                            <input type="text" id="roomType" class="form-control"
                                placeholder="cari berdasarkan jenis kamar atau nomor kamar...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="roomTable">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Foto Room</th>
            <th>Jenis Kamar</th>
            <th>Harga /Malam</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody class="text-center align-middle">
        @foreach ($kamars as $kamar)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img src="{{ asset('storage/' . $kamar->photo_kamar) }}" alt="Room Image" style="width: 100px; height: 70px; object-fit: cover;" class="rounded">
            </td>
            <td>{{ $kamar->jenis_kamar }}</td>
            <td>{{ $kamar->harga_permalam }}</td>
            <td class="description">{{ $kamar->deskripsi }}</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $kamar->id }}">Edit</button>
                <form action="{{ route('admin.kamardepan.destroy', $kamar->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kamar ini?')">Delete</button>
</form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal for Add Room -->

<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
      <form action="{{ route('admin.jeniskamar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="roomType" class="form-label">Jenis Kamar</label>
            <input type="text" class="form-control" id="jenis_kamar" name="jenis_kamar">
          </div>
          <div class="mb-3">
            <label for="roomPrice" class="form-label">Harga/Malam</label>
            <input type="number" class="form-control" id="harga_permalam" name="harga_permalam">
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="roomImages" class="form-label">Foto Kamar</label>
            <input type="file" class="form-control" id="photo_kamar" name="photo_kamar" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Tambahkan Kamar</button>
        </div>
      </form>
    </div>
  </div>
</div>



    <!-- Modal for Edit (Optional) -->
<!-- Modal Edit Kamar -->
@foreach ($kamars as $kamar)
<div class="modal fade" id="editModal{{ $kamar->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $kamar->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel{{ $kamar->id }}">Edit Kamar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-3">
            <label for="jenis_kamar{{ $kamar->id }}" class="form-label">Jenis Kamar</label>
            <input type="text" id="jenis_kamar{{ $kamar->id }}" name="jenis_kamar" class="form-control" value="{{ old('jenis_kamar', $kamar->jenis_kamar) }}" required>
          </div>

          <div class="mb-3">
            <label for="harga_permalam{{ $kamar->id }}" class="form-label">Harga Per Malam</label>
            <input type="number" id="harga_permalam{{ $kamar->id }}" name="harga_permalam" class="form-control" value="{{ old('harga_permalam', $kamar->harga_permalam) }}" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi{{ $kamar->id }}" class="form-label">Deskripsi</label>
            <textarea id="deskripsi{{ $kamar->id }}" name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="photo_kamar{{ $kamar->id }}" class="form-label">Foto Kamar</label>
            <input type="file" id="photo_kamar{{ $kamar->id }}" name="photo_kamar" class="form-control">
            @if ($kamar->photo_kamar)
              <img src="{{ asset('storage/' . $kamar->photo_kamar) }}" alt="Current Photo" class="mt-2 rounded" style="width: 150px;">
            @endif
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach


        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const alert = $('#alertSuccess');
        if (alert.length > 0) {
            setTimeout(function() {
                alert.fadeOut();
            }, 3000);
        }
    });
    </script>
</body>

</html>
