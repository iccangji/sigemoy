@extends('main')

@section('konten')
    <div class="main-content" @if ($level == 'penginput') style="padding-left:20px;" @endif>
        <section class="section">
            <div class="section-header">
                <h1>Data KPU</h1>
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
                                <h2 class="section-title">Data KPU</h2>
                                @if ($level != 'viewer')
                                    <div>
                                        <!-- Tombol Upload Excel -->
                                        <button class="btn btn-success btn-round mr-2" data-toggle="modal"
                                            data-target="#UploadExcel">
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
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif



                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="form-group">
                                        <label for="showEntries">Data Perbaris :</label>
                                        <select id="showEntries" class="form-control" style="width: 100px;">
                                            <option value="{{ route('data-kpu.index') }}?size=50"
                                                @if ($selected_size == 50) selected @endif>50</option>
                                            <option value="{{ route('data-kpu.index') }}?size=100"
                                                @if ($selected_size == 100) selected @endif>100</option>
                                            <option value="{{ route('data-kpu.index') }}?size=200"
                                                @if ($selected_size == 200) selected @endif>200</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <form id="search-form" method="GET" action="{{ route('data-kpu.index') }}">
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
                                                <th scope="col">Nama </th>
                                                <th scope="col">Jenis Kelamin </th>
                                                <th scope="col">Usia</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">TPS</th>
                                                <th scope="col">Kelurahan</th>
                                                @if ($level != 'viewer')
                                                    <th scope="col">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $number = ($current_page - 1) * $selected_size + 1;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $number }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->jenis_kelamin }}</td>
                                                    <td>{{ $item->usia }}</td>
                                                    <td>{{ $item->alamat }}</td>
                                                    <td>{{ $item->tps }}</td>
                                                    <td>{{ $item->kelurahan }}</td>
                                                    @if ($level != 'viewer')
                                                        <td class="text-center text-nowrap">
                                                            <a href="#" class="btn btn-icon btn-info"
                                                                data-toggle="modal"
                                                                data-target="#editdata-{{ $item->id }}"><i
                                                                    class="far fa-edit"></i></a>
                                                            <form action="{{ route('data-kpu.destroy', $item->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-icon btn-danger"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i
                                                                        class="fas fa-times"></i></button>
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
                                                    <a href="{{ $data->previousPageUrl() }}&size={{ $selected_size }}&search={{ $search }}"
                                                        data-page="{{ $data->currentPage() - 1 }}"
                                                        class="page-link">Previous</a>
                                                @endif
                                            </li>
                                            <li>
                                                <a class="page-link disabled bordered">{{ $data->currentPage() }}</a>
                                            </li>
                                            <li class="page-item">
                                                @if ($data->hasMorePages())
                                                    <a href="{{ $data->nextPageUrl() }}&size={{ $selected_size }}&search={{ $search }}"
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
                    <h5 class="modal-title">Tambah Data KPU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('data-kpu.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" id="nama" placeholder="Masukan Nama Pemilih"
                                class="form-control" value="{{ old('nama') }}" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin"
                                placeholder="Masukan Jenis Kelamin" value="{{ old('jenis_kelamin') }}" required>
                            @error('jenis_kelamin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Usia</label>
                            <input type="number" class="form-control" name="usia" id="usia"
                                placeholder="Masukan Usia" value="{{ old('usia') }}" required>
                            @error('usia')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat"
                                placeholder="Masukan Alamat" value="{{ old('alamat') }}" required>
                            @error('alamat')
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
                            <label for="kelurahan">Kelurahan</label>
                            <select name="kelurahan" class="form-control" id="kelurahan" required>
                                <option value="">--Pilih Kelurahan--</option>
                                @foreach ($kelurahan as $p)
                                    <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            @error('kelurahan')
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
                        <h5 class="modal-title">Edit Data KPU</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('data-kpu.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" id="nama" placeholder="Masukan Nama Pemilih"
                                    class="form-control" value="{{ $item->nama }}" required>
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin"
                                    placeholder="Masukan Jenis Kelamin" value="{{ $item->jenis_kelamin }}" required>
                                @error('jenis_kelamin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Usia</label>
                                <input type="number" class="form-control" name="usia" id="usia"
                                    placeholder="Masukan Usia" value="{{ $item->usia }}" required>
                                @error('usia')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="alamat"
                                    placeholder="Masukan Alamat" value="{{ $item->alamat }}" required>
                                @error('alamat')
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
                                <label for="kelurahan">Kelurahan</label>
                                <select name="kelurahan" class="form-control" id="kelurahan" required>
                                    <option value="">--Pilih Kelurahan--</option>
                                    @foreach ($kelurahan as $p)
                                        <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kelurahan')
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
    <div class="modal fade" id="UploadExcel" tabindex="-1" role="dialog" aria-labelledby="UploadExcel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kpu.import') }}" method="POST" enctype="multipart/form-data">
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
    </script>
@endsection