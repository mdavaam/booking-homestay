<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Buat Transaksi</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    @include('layouts.sidebar-top')

    <div class="container-fluid py-4">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h4>Buat Transaksi Baru</h4>
<div class="d-flex">
    <a href="{{ route('status.transaksi') }}" class="btn btn-outline-primary ms-auto">
        <i class="fas fa-file-alt me-2"></i>
    </a>
</div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('debug'))
                        <div class="alert alert-info">
                            {{ session('debug') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.transaksi.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <!-- Nama Pemesan -->
                            <div class="col-md-6">
                                <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                <input type="text" name="nama_pemesan" class="form-control @error('nama_pemesan') is-invalid @enderror" value="{{ old('nama_pemesan') }}">
                                @error('nama_pemesan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Pilih Kamar -->
                            <div class="col-md-6">
                                <label for="id_kamar" class="form-label">Pilih Kamar</label>
                                <select name="id_kamar" class="form-select @error('id_kamar') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
@foreach ($namaKamar as $kamar)
    @if ($kamar->status == 'tersedia')
        <option value="{{ $kamar->id }}" {{ old('id_kamar') == $kamar->id ? 'selected' : '' }}>
             {{ $kamar->jenis_kamar }} (Rp {{ number_format($kamar->harga_permalam, 0, ',', '.') }}/malam)
        </option>
    @endif
@endforeach


                                </select>
                                @error('id_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- No HP -->
                            <div class="col-md-6">
                                <label for="nohp" class="form-label">Nomor HP</label>
                                <input type="text" name="nohp" class="form-control @error('nohp') is-invalid @enderror" value="{{ old('nohp') }}">
                                @error('nohp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Kebangsaan -->
                            <div class="col-md-6">
                                <label for="kebangsaan" class="form-label">Kebangsaan</label>
                                <input type="text" name="kebangsaan" class="form-control @error('kebangsaan') is-invalid @enderror" value="{{ old('kebangsaan', 'Indonesia') }}" required>
                                @error('kebangsaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Tanggal Pemesanan -->
                            <div class="col-md-6">
                                <label for="daterange" class="form-label">Tanggal Pemesanan</label>
                                <input type="text" name="daterange" id="daterange" class="form-control @error('daterange') is-invalid @enderror" placeholder="dd-mm-yyyy - dd-mm-yyyy" value="{{ old('daterange') }}">
                                @error('daterange') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Hidden check_in & check_out -->
                            <input type="hidden" name="check_in" id="check_in">
                            <input type="hidden" name="check_out" id="check_out">

                            <!-- Metode Pembayaran -->
                            <div class="col-md-6">
                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" required>
                                    <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="midtrans" {{ old('metode_pembayaran') == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                                </select>
                                @error('metode_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Total Harga -->
                            <div class="col-md-6">
                                <label for="total_harga" class="form-label">Total Harga</label>
                                <input type="hidden" name="total_harga" id="total_harga">
                                <input type="text" id="total_harga_display" class="form-control" readonly>
                            </div>

                            <!-- Tombol -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Lanjut ke Pembayaran</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>

        flatpickr("#daterange", {
            mode: "range",
            dateFormat: "d-m-Y",
            minDate: "today",
            locale: {
                firstDayOfWeek: 1
            },
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    const checkIn = selectedDates[0];
                    const checkOut = selectedDates[1];
                    document.getElementById('check_in').value = checkIn.toISOString().split('T')[0];
                    document.getElementById('check_out').value = checkOut.toISOString().split('T')[0];
                    hitungTotalHarga();
                }
            }
        });

        document.querySelector('select[name="id_kamar"]').addEventListener('change', hitungTotalHarga);

        function hitungTotalHarga() {
            const idKamar = document.querySelector('select[name="id_kamar"]').value;
            const hargaPerMalam = hargaKamar[idKamar] || 0;
            const checkIn = new Date(document.getElementById('check_in').value);
            const checkOut = new Date(document.getElementById('check_out').value);

            if (!isNaN(checkIn) && !isNaN(checkOut) && hargaPerMalam > 0) {
                const durasi = Math.max(1, Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)));
                const total = durasi * hargaPerMalam;
                document.getElementById('total_harga').value = total;
                document.getElementById('total_harga_display').value = `Rp ${total.toLocaleString('id-ID')}`;
            } else {
                document.getElementById('total_harga').value = '';
                document.getElementById('total_harga_display').value = '';
            }
        }
    </script>
        <script>
const hargaKamar = @json($namaKamar->pluck('harga_permalam', 'id'));
</script>

</body>
</html>
