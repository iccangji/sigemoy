@extends('main')

@section('konten')
    <div class="main-content" @if ($level == 'penginput') style="padding-left:20px;" @endif>
        <section class="section">
            <div class="section-header">
                <h1>Data Ganda</h1>
                {{-- <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Informasi Data Pemilih</a></div>
        <div class="breadcrumb-item">Data Pemilih</div>
      </div> --}}
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="section-title">Data Ganda</h2>
                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="form-group">
                                        <label for="showEntries">Data Perbaris :</label>
                                        <select id="showEntries" class="form-control" style="width: 100px;">
                                            <option value="{{ route('ganda.index') }}?size=50"
                                                @if ($selected_size == 50) selected @endif>50</option>
                                            <option value="{{ route('ganda.index') }}?size=100"
                                                @if ($selected_size == 100) selected @endif>100</option>
                                            <option value="{{ route('ganda.index') }}?size=200"
                                                @if ($selected_size == 200) selected @endif>200</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <form id="search-form" method="GET" action="{{ route('ganda.index') }}">
                                            <label for="Pencarian Data">Pencarian Data</label>
                                            <input type="text" name="search" class="form-control" id="searchInput"
                                                value="{{ $search }}" placeholder="Masukkan nama...">
                                            {{-- <button type="submit" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button> --}}
                                        </form>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama Pemilih</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">No. HP</th>
                                                <th scope="col">Hub. Keluarga</th>
                                                <th scope="col">TPS</th>
                                                <th scope="col">Kelurahan</th>
                                                <th scope="col">Kecamatan</th>
                                                <th scope="col">Status`</th>
                                                @if ($level != 'viewer')
                                                    <th scope="col">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $number = ($data->currentPage() - 1) * $selected_size + 1;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $number }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->no_hp }}</td>
                                                    <td>{{ $item->hub_keluarga }}</td>
                                                    <td>{{ $item->tps }}</td>
                                                    <td>{{ $item->kelurahan }}</td>
                                                    <td>{{ $item->kecamatan }}</td>
                                                    <td>
                                                        <div class="badge badge-warning">Data Ganda</div>
                                                    </td>
                                                    @if ($level != 'viewer')
                                                        <td class="text-center text-nowrap">
                                                            <a href="#" class="btn btn-icon btn-info"
                                                                data-toggle="modal"
                                                                data-target="#report-{{ $item->id }}"><i
                                                                    class="far fa-eye"></i></a>
                                                            <a href="#" class="btn btn-icon btn-success"
                                                                data-toggle="modal"
                                                                data-target="#edit-{{ $item->id }}"><i
                                                                    class="far fa-edit"> </i></a>
                                                            <form action="{{ route('ganda.destroy', $item->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon btn-danger delete-confirm">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                                @php
                                                    $number++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="footer  d-flex justify-content-between align-items-center">
                                    <span>Total {{ $count }} Data</span>

                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">

                                            <li class="page-item">
                                                @if ($data->currentPage() > 1)
                                                    <a href="{{ $data->previousPageUrl() }}&size={{ $selected_size }}"
                                                        data-page="{{ $data->currentPage() - 1 }}"
                                                        class="page-link">Previous</a>
                                                @endif
                                            </li>
                                            <li>
                                                <a class="page-link disabled bordered">{{ $data->currentPage() }}</a>
                                            </li>
                                            <li class="page-item">
                                                @if ($data->hasMorePages())
                                                    <a href="{{ $data->nextPageUrl() }}&size={{ $selected_size }}"
                                                        data-page="{{ $data->currentPage() + 1 }}"
                                                        class="page-link">Next</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>


    {{-- modal detail --}}
    @foreach ($data as $item)
        <div class="modal fade" id="report-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="report-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-left w-75">{{ $item->report }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Data -->
        <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="edit-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data pemilih</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pemilih.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Pemilh</label>
                                <input type="text" name="nama_pemilih" id="nama_pemilih"
                                    placeholder="Masukan Nama Pemilih" class="form-control" value="{{ $item->nama }}"
                                    required>
                                @error('nama_pemilih')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control" name="NIK" id="NIK"
                                    placeholder="Masukan NIK" value="{{ $item->nik }}" required>
                                @error('NIK')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp"
                                    placeholder="Masukan Nomor Handphone" value="{{ $item->no_hp }}" required>
                                @error('no_hp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="hub_keluarga">Hubungan Keluarga</label>
                                <select name="hub_keluarga" class="form-control" required>
                                    <option value="">--Pilih Hubungan Keluarga--</option>
                                    <option value="Suami/Istri" @if ($item->hub_keluarga == 'Suami/Istri') selected @endif>
                                        Suami/Istri</option>
                                    <option value="Anak" @if ($item->hub_keluarga == 'Anak') selected @endif>Anak</option>
                                    <option value="Saudara Kandung" @if ($item->hub_keluarga == 'Saudara Kandung') selected @endif>
                                        Saudara Kandung</option>
                                    <option value="Mertua" @if ($item->hub_keluarga == 'Mertua') selected @endif>Mertua
                                    </option>
                                    <option value="Ponakan" @if ($item->hub_keluarga == 'Ponakan') selected @endif>Ponakan
                                    </option>
                                    <option value="Ipar" @if ($item->hub_keluarga == 'Ipar') selected @endif>Ipar</option>
                                </select>
                                @error('hub_keluarga')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" class="form-control" id="kecamatan-insert" required>
                                    <option value="">--Pilih Kecamatan--</option>
                                    @foreach ($kecamatan as $p)
                                        <option value="{{ $p->id }}"
                                            @if ($item->kecamatan == $p->nama) selected @endif>{{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kelurahan">Kelurahan</label>
                                <select name="kelurahan" id="kelurahan-insert" class="form-control" required>
                                    <option value="{{ $item->kelurahan }}">{{ $item->kelurahan }}</option>
                                </select>
                                @error('kelurahan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>TPS</label>
                                <input type="text" class="form-control" name="tps" id="tps"
                                    placeholder="Masukan TPS" value="{{ $item->tps }}" required>
                                @error('tps')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama Penanggung Jawab</label>
                                <input type="text" class="form-control" name="nama_pj" id="nama_pj"
                                    placeholder="Masukan Nama Penanggung Jawab" value="{{ old('nama_pj') }}" required>
                                @error('nama_pj')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor HP Penanggung Jawab</label>
                                <input type="text" class="form-control" name="no_hp_pj" id="no_hp_pj"
                                    placeholder="Masukan Nomor HP Penanggung Jawab" value="{{ old('no_hp_pj') }}"
                                    required>
                                @error('no_hp_pj')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        document.getElementById('showEntries').addEventListener('change', function(event) {
            var selectedValue = event.target.value;
            if (selectedValue) {
                window.location.href = selectedValue;
            }
        });

        $(document).ready(function() {
            $('#kecamatan-insert').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: "{{ url('pemilih-lokasi') }}/" + kecamatanId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kelurahan-insert').empty();
                            $('#kelurahan-insert').append(
                                '<option value="">-- Pilih Kelurahan --</option>');
                            $.each(data, function(key, kelurahan) {
                                $('#kelurahan-insert').append('<option value="' +
                                    kelurahan.nama + '">' + kelurahan.nama +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#kelurahan-insert').empty();
                }
            });

            $('#kecamatan-edit').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: "{{ url('pemilih-lokasi') }}/" + kecamatanId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#kelurahan-edit').empty();
                            $('#kelurahan-edit').append(
                                '<option value="">-- Pilih Kelurahan --</option>');
                            $.each(data, function(key, kelurahan) {
                                $('#kelurahan-edit').append('<option value="' +
                                    kelurahan.nama + '">' + kelurahan.nama +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#kelurahan-edit').empty();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            $('.delete-confirm').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'danger',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        @endif
    </script>
@endsection
