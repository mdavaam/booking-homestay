<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Room</title>
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
            <th>Foto Kamar</th>
            <th>Tipe Kamar</th>
            <th>Nama Kamar</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody class="text-center align-middle">
        @foreach ($kamars as $kamar)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>
        <img src="{{ asset('storage/' . $kamar->photo_utama) }}" alt="Room Image" style="width: 100px; height: 70px; object-fit: cover;" class="rounded">
    </td>
    <td>{{ $kamar->jenis_kamar }}</td>
    <td>{{ $kamar->nama_kamar }}</td>
    <td>{{ $kamar->harga_permalam }}</td>
<td class="text-wrap">
    {{ $kamar->deskripsi }}
</td>
<td>
    <span class="badge {{ $kamar->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
        {{ $kamar->status }}
    </span>
</td>

    <td>
        <button type="button" class="btn btn-primary btn-sm me-1"
                data-bs-toggle="modal" data-bs-target="#addPhoto{{ $kamar->id }}">
        <i class="bi bi-plus-circle"></i> Add
        </button>
        <button type="button" class="btn btn-warning btn-sm me-1"
                data-bs-toggle="modal" data-bs-target="#editModal{{ $kamar->id }}">
            <i class="bi bi-pencil-square"></i> Edit
        </button>
    <form action="{{ route('admin.kamardalam.destroy', $kamar->id) }}" method="POST" style="display:inline-block;">
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
      <form action="{{ route('admin.kamardalamStore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <select class="form-control" id="jenis_kamar" name="jenis_kamar" required>
            <option value="" disabled selected>-- Pilih Jenis Kamar --</option>
            @foreach ($tipekamar as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="harga_permalam" class="form-label">Harga/Malam</label>
            <input type="number" class="form-control" id="harga_permalam" name="harga_permalam">
          </div>
          <div class="mb-3">
            <label for="nama_kamar" class="form-label">Nama Kamar</label>
            <input type="text" class="form-control" id="nama_kamar" name="nama_kamar">
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="note" name="deskripsi" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="photo_utama" class="form-label">Foto Kamar</label>
            <input type="file" class="form-control" id="photo_utama" name="photo_utama" accept="image/*" multiple>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Room</button>
        </div>
      </form>
    </div>
  </div>
</div>

        <!-- Modal for Add Photo  -->

@foreach ($kamars as $kamar)
<div class="modal fade" id="addPhoto{{ $kamar->id }}" tabindex="-1" aria-labelledby="addPhotoLabel{{ $kamar->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="{{ route('admin.addPhoto', ['nama_kamar' => $kamar->nama_kamar]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo_kamar{{ $kamar->id }}" class="form-label">Pilih Foto Kamar</label>
    <input type="file" id="photo_kamar{{ $kamar->id }}" name="photo_kamar[]" class="form-control" accept="image/*" multiple required>
    <button type="submit" class="btn btn-primary mt-3">Upload</button>
</form>
    </div>
  </div>
</div>
@endforeach

    <!-- Modal Edit -->
@foreach ($kamars as $kamar)
<div class="modal fade" id="editModal{{ $kamar->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $kamar->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            @isset($kamar)
                <form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
          {{-- Jenis Kamar --}}
          <div class="mb-3">
            <label for="jenis_kamar{{ $kamar->id }}" class="form-label">Jenis Kamar</label>
            <input type="text" name="jenis_kamar" id="jenis_kamar{{ $kamar->id }}" class="form-control" value="{{ old('jenis_kamar', $kamar->jenis_kamar) }}" required>
          </div>

          {{-- Nomor Kamar --}}
          <div class="mb-3">
            <label for="nama_kamar{{ $kamar->id }}" class="form-label">Nomor Kamar</label>
            <input type="text" name="nama_kamar" id="nama_kamar{{ $kamar->id }}" class="form-control" value="{{ old('nama_kamar', $kamar->nama_kamar) }}" required>
          </div>

          {{-- Harga Per Malam --}}
          <div class="mb-3">
            <label for="harga_permalam{{ $kamar->id }}" class="form-label">Harga Per Malam</label>
            <input type="number" name="harga_permalam" id="harga_permalam{{ $kamar->id }}" class="form-control" value="{{ old('harga_permalam', $kamar->harga_permalam) }}" required min="0">
          </div>

          {{-- Deskripsi --}}
          <div class="mb-3">
            <label for="deskripsi{{ $kamar->id }}" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi{{ $kamar->id }}" class="form-control" rows="3" required>{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
          </div>

          {{-- Upload Foto Kamar --}}
          <div class="mb-3">
            <label for="photo_path{{ $kamar->id }}" class="form-label">Foto Kamar (Maksimal 4 Gambar)</label>
            <input type="file" name="photo_path[]" id="photo_path{{ $kamar->id }}" class="form-control" multiple accept="image/*" onchange="restrictFiles(this, 4)">
            <small class="form-text text-muted">Pilih hingga 4 gambar.</small>
          </div>

          {{-- Status --}}
          <div class="mb-3">
            <label for="status{{ $kamar->id }}" class="form-label">Status Kamar</label>
            <select name="status" id="status{{ $kamar->id }}" class="form-control" required>
              <option value="tersedia" {{ old('status', $kamar->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
              <option value="tidak Tersedia" {{ old('status', $kamar->status) == 'tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
      @endisset

    </div>
  </div>
</div>
@endforeach


    <!-- Bootstrap JS and Popper.js from CDN -->
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
        <script>
        function restrictFiles(input, maxFiles) {
            if (input.files.length > maxFiles) {
                alert('Maksimal ' + maxFiles + ' gambar aja, bro!');
                input.value = '';
            }
        }
        </script>
</body>

</html>
