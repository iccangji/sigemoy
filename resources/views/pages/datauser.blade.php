@extends('main')

@section('konten')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data User</h1>
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
                                <h2 class="section-title">Data User</h2>
                                @if ($level != 'viewer')
                                    <div>
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



                                {{-- <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="form-group">
                  <label for="showEntries">Data Perbaris :</label>
                  <select id="showEntries" class="form-control" style="width: 100px;">
                    <option value="/pemilih?size=50"
                      @if ($selected_size == 50)
                      selected
                      @endif>50</option>
                    <option value="/pemilih?size=100"
                      @if ($selected_size == 100)
                      selected
                      @endif>100</option>
                    <option value="/pemilih?size=200"
                      @if ($selected_size == 200)
                      selected
                      @endif>200</option>
                  </select>
                </div>
                <div class="form-group">
                  <form id="search-form" method="GET" action="./pemilih">
                    <label for="Pencarian Data">Pencarian Data</label>
                    <input type="text" name="search" class="form-control" id="searchInput" value="{{ $search }}" placeholder="Masukkan nama...">
                  </form>
                </div>
              </div> --}}

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Role</th>
                                                @if ($level != 'viewer')
                                                    <th scope="col">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @php
                        $number = ($current_page-1)*$selected_size + 1;
                    @endphp --}}
                                            @foreach ($data as $item)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->user }}</td>
                                                    <td>{{ $item->level }}</td>
                                                    @if ($level != 'viewer')
                                                        <td class="text-center text-nowrap">
                                                            <a href="#" class="btn btn-icon btn-info"
                                                                data-toggle="modal"
                                                                data-target="#editdata-{{ $item->id }}"><i
                                                                    class="far fa-edit"></i></a>
                                                            <form action="{{ route('data-user.destroy', $item->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-icon btn-danger delete-confirm">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- @php
                        $number++;
                    @endphp --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="footer  d-flex justify-content-between align-items-center">
                                    <span>Total {{ $count }} Data</span>

                                    {{-- <nav aria-label="Page navigation example">
                  <ul class="pagination">

                    <li class="page-item">
                      @if ($data->currentPage() > 1)
                      <a href="{{ $data->previousPageUrl() }}&size={{$selected_size}}" data-page="{{ $data->currentPage() - 1 }}" class="page-link">Previous</a>
                      @endif
                    </li>
                    <li>
                      <a class="page-link disabled bordered">{{ $data->currentPage() }}</a>
                    </li>
                    <li class="page-item">@if ($data->hasMorePages())
                      <a href="{{ $data->nextPageUrl() }}&size={{$selected_size}}" data-page="{{ $data->currentPage() + 1 }}" class="page-link">Next</a>
                      @endif
                    </li>
                  </ul>
                </nav> --}}
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
                    <h5 class="modal-title">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('data-user.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Masukan Username" class="form-control"
                                value="{{ old('username') }}" required>
                            @error('user')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Masukan Password Minimal 8 Karakter" value="{{ old('password') }}" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="level">Level User</label>
                            <select name="level" class="form-control" required>
                                <option value="">--Pilih Level User--</option>
                                <option value="admin">Admin</option>
                                <option value="penginput">Penginput</option>
                                <option value="viewer">Viewer</option>
                            </select>
                            @error('level')
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
                        <h5 class="modal-title">Edit Data User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('data-user.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Masukkan Username" value="{{ $item->user }}" required>
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukkan Password Baru" required>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="level">Level User</label>
                                <select name="level" class="form-control" required>
                                    <option value="">--Pilih Level User--</option>
                                    <option value="admin" {{ $item->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="penginput" {{ $item->level == 'penginput' ? 'selected' : '' }}>
                                        Penginput</option>
                                    <option value="viewer" {{ $item->level == 'viewer' ? 'selected' : '' }}>Viewer
                                    </option>
                                </select>
                                @error('level')
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


<script>
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

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
            
            @if(session('error'))
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
