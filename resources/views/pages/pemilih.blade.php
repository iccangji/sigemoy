@extends('main')

@section('konten')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pemilih</h1>
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
                                <h2 class="section-title">Data Pemilih</h2>
                                @if ($level != 'viewer')
                                    <div>
                                        <!-- Tombol Upload Excel -->
                                        <button class="btn btn-success btn-round mr-2" data-toggle="modal"
                                            data-target="#uploadExcel">
                                            <i class="fa fa-file-excel"></i> Upload Excel
                                        </button>

                                        <!-- Tombol Tambah Data -->
                                        <button class="btn btn-primary btn-round" data-toggle="modal"
                                            data-target="#Tambahdata">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="form-group">
                                        <label for="showEntries">Data Perbaris :</label>
                                        <select id="showEntries" class="form-control" style="width: 100px;">
                                            <option value="{{ $route }}?size=50"
                                                @if ($selected_size == 50) selected @endif>50</option>
                                            <option value="{{ $route }}?size=100"
                                                @if ($selected_size == 100) selected @endif>100</option>
                                            <option value="{{ $route }}?size=200"
                                                @if ($selected_size == 200) selected @endif>200</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-flex align-items-end">
                                        <form id="search-form" method="GET" action="{{ $route }}">
                                            <label for="Pencarian Data">Pencarian Data</label>
                                            <input type="text" name="search" class="form-control" id="searchInput"
                                                value="{{ $search }}" placeholder="Masukkan nama...">
                                            {{-- <button type="submit" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button> --}}
                                        </form>
                                        <div class="">
                                            <button class="ml-2 p-2 rounded btn btn-primary btn-round" data-toggle="modal"
                                                data-target="#filterSearch">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                        </div>
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
                                                <th scope="col">Nama PJ</th>
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
                                                    <td>{{ $item->nama_pj }}</td>
                                                    @if ($level != 'viewer')
                                                        <td class="text-center text-nowrap">
                                                            <a href="#" class="btn btn-icon btn-info"
                                                                data-toggle="modal"
                                                                data-target="#editdata-{{ $item->id }}"><i
                                                                    class="far fa-edit"></i></a>
                                                            <form action="{{ route('pemilih.destroy', $item->id) }}"
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

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="Tambahdata" tabindex="-1" role="dialog" aria-labelledby="Tambahdata" aria-hidden="true">
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
                                placeholder="Masukan Nama Pemilih" class="form-control"
                                value="{{ old('nama_pemilih') }}" required>
                            @error('nama_pemilih')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control" name="NIK" id="NIK"
                                placeholder="Masukan NIK" value="{{ old('NIK') }}" required>
                            @error('NIK')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp"
                                placeholder="Masukan Nomor Handphone" value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hub_keluarga">Hubungan Keluarga</label>
                            <select name="hub_keluarga" class="form-control" required>
                                <option value="">--Pilih Hubungan Keluarga--</option>
                                <option value="Suami/Istri">Suami/Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Saudara Kandung">Saudara Kandung</option>
                                <option value="Sepupu">Sepupu</option>
                                <option value="Mertua">Mertua</option>
                                <option value="Ponakan">Ponakan</option>
                                <option value="Ipar">Ipar</option>
                                <option value="Teman">Teman</option>
                                <option value="Tetangga">Tetangga</option>
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
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan-insert" class="form-control" required>
                                <option value="">--Pilih Kelurahan--</option>

                            </select>
                            @error('kelurahan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>TPS</label>
                            <input type="text" class="form-control" name="tps" id="tps"
                                placeholder="Masukan TPS" value="{{ old('tps') }}" required>
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
                                placeholder="Masukan Nomor HP Penanggung Jawab" value="{{ old('no_hp_pj') }}" required>
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



    {{-- modal edit data --}}
    @foreach ($data as $item)
        <div class="modal fade" id="editdata-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editdata-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data pemilih</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pemilih.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
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
                                    <small class="text-danger"></small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp"
                                    placeholder="Masukan Nomor Handphone" value="{{ $item->no_hp }}" required>
                                @error('no_hp')
                                    <small class="text-danger"></small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="hub_keluarga">Hubungan Keluarga</label>
                                <select name="hub_keluarga" class="form-control" required>
                                    <option value="">--Pilih Hubungan Keluarga--</option>
                                    <option value="Suami/Istri" @if ($item->hub_keluarga == 'Suami/Istri') selected @endif>
                                        Suami/Istri
                                    </option>
                                    <option value="Anak" @if ($item->hub_keluarga == 'Anak') selected @endif>Anak</option>
                                    <option value="Saudara Kandung" @if ($item->hub_keluarga == 'Saudara Kandung') selected @endif>
                                        Saudara Kandung</option>
                                    <option value="Mertua" @if ($item->hub_keluarga == 'Mertua') selected @endif>Mertua
                                    </option>
                                    <option value="Sepupu" @if ($item->hub_keluarga == 'Sepupu') selected @endif>Sepupu
                                    </option>
                                    <option value="Ponakan" @if ($item->hub_keluarga == 'Ponakan') selected @endif>Ponakan
                                    </option>
                                    <option value="Ipar" @if ($item->hub_keluarga == 'Ipar') selected @endif>Ipar
                                    </option>
                                    <option value="Orang Tua" @if ($item->hub_keluarga == 'Orang Tua') selected @endif>Orang Tua
                                    </option>
                                    <option value="Teman" @if ($item->hub_keluarga == 'Teman') selected @endif>Teman
                                    </option>
                                    <option value="Tetangga" @if ($item->hub_keluarga == 'Tetangga') selected @endif>Tetangga
                                    </option>
                                    {{-- @endforeach --}}
                                </select>
                                @error('hub_keluarga')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" class="form-control" id="kecamatan-edit" required>
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
                                <select name="kelurahan" id="kelurahan-edit" class="form-control" required>
                                    <option value="">--Pilih Kelurahan--</option>
                                    @foreach ($kelurahan as $p)
                                        <option value="{{ $p->nama }}"
                                            @if ($item->kelurahan == $p->nama) selected @endif>{{ $p->nama }}
                                        </option>
                                    @endforeach
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
                                    placeholder="Masukan Nama Penanggung Jawab" value="{{ $item->nama_pj }}" required>
                                @error('nama_pj')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor HP Penanggung Jawab</label>
                                <input type="text" class="form-control" name="no_hp_pj" id="no_hp_pj"
                                    placeholder="Masukan Nomor HP Penanggung Jawab" value="{{ $item->no_hp_pj }}"
                                    required>
                                @error('no_hp_pj')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mb-2" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-success">Edit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal upload data excel  --}}
    <div class="modal fade" id="filterSearch" tabindex="-1" role="dialog" aria-labelledby="filterSearch"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pencarian Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pemilih.filter') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Pemilh</label>
                            <input type="text" name="nama_pemilih" id="nama_pemilih"
                                placeholder="Masukan Nama Pemilih" class="form-control" value="">
                            @error('nama_pemilih')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" class="form-control" id="kecamatan-edit">
                                <option value="">--Pilih Kecamatan--</option>
                                @foreach ($kecamatan as $p)
                                    <option value="{{ $p->nama }}">{{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan-edit" class="form-control">
                                <option value="">--Pilih Kelurahan--</option>
                                @foreach ($kelurahan as $p)
                                    <option value="{{ $p->nama }}">{{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelurahan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>TPS</label>
                            <input type="text" class="form-control" name="tps" id="tps"
                                placeholder="Masukan TPS" value="">
                            @error('tps')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mb-2" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success">Filter Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal upload data excel  --}}
    <div class="modal fade" id="uploadExcel" tabindex="-1" role="dialog" aria-labelledby="uploadExcel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pemilih.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Upload Data Excel</label>
                            <input type="file" name="upload" id="upload" class="form-control"
                                value="{{ old('upload') }}" required>
                            <p class="text-warning">Ukuran Maksimal File 2 Mb</p>
                            @error('upload')
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
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                timer: 5000,
                showConfirmButton: true
            });
        @endif
    </script>
@endsection
