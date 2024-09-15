@extends('main')

@section('konten')

<div class="main-content"
  @if ($level == 'penginput')
    style="padding-left:20px;"
  @endif
>
    <section class="section">
      <div class="section-header">
        <h1>Data Pemilih</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="#">Informasi Data Pemilih</a></div>
          <div class="breadcrumb-item">Data Pemilih</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Data Pemilih</h2>
        <p class="section-lead">
          Data Pemilih. Anda sebagai admin bisa memodifikasinya.
        </p>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Data Pemilih</h3>
                <div>
                    <!-- Tombol Upload Excel -->
                    <button class="btn btn-success btn-round mr-2" data-toggle="modal" data-target="#UploadExcel">
                        <i class="fa fa-file-excel"></i> Upload Excel
                    </button>
                    
                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#Tambahdata">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>

              <div class="card-body">
                @if(session('loginError'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                @endif

                <div class="d-flex justify-content-between mb-3">
                  <div class="form-group">
                      <label for="showEntries">Data Perbaris :</label>
                      <select id="showEntries" class="form-control" style="width: 100px;">
                          <option value="5">5</option>
                          <option value="10" selected>10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="">Cari Data</label>
                      <input type="text" id="searchInput" class="form-control" placeholder="Cari Data....">
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
                                <th scope="col">Nama PJ</th>
                                <th scope="col">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td class="text-center">
                                  {{-- tambahkan di data-target="#editdata"-> -{{ $item->id }} --}}
                                  <a href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#editdata"><i class="far fa-edit"></i></a>
                                  <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i class="fas fa-times"></i></button>
                                  </form>
                                </td>
        
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td class="text-center">
                                  {{-- tambahkan di data-target="#editdata"-> -{{ $item->id }} --}}
                                  <a href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#editdata"><i class="far fa-edit"></i></a>
                                  <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i class="fas fa-times"></i></button>
                                  </form>
                                </td>
        
                            </tr>
                            <tr>

                              <td>3</td>
                              <td>Mark</td>
                              <td>Otto</td>
                              <td>@mdo</td>
                              <td>Mark</td>
                              <td>Otto</td>
                              <td>@mdo</td>
                                <td class="text-center">
                                  {{-- tambahkan di data-target="#editdata"-> -{{ $item->id }} --}}
                                  <a href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#editdata"><i class="far fa-edit"></i></a>
                                  <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i class="fas fa-times"></i></button>
                                  </form>
                                </td>
        
                            </tr>
                        </tbody>
                    </table>
                  </div>
              
                <div class="footer  d-flex justify-content-between align-items-center">
                  <span>Total 10 Data</span>

                  <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                      <li class="page-item"><a class="page-link" href="#">Next</a></li>
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
        <form action="#" method="POST" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <div class="modal-body">
            <div class="form-group">
                <label>Nama Pemilh</label>
                <input type="text" name="nama_pemilih" id="nama_pemilih" placeholder="Masukan Nama Pemilih" class="form-control" value="{{ old('nama_pemilih') }}" required>
                @error('nama_pemilih')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>NIK</label>
                <input type="text" class="form-control" name="NIK" id="NIK" placeholder="Masukan NIK" value="{{ old('NIK') }}" required>
                @error('NIK')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukan Nomor Handphone" value="{{ old('no_hp') }}" required>
                @error('no_hp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="hub_keluarga">Hubungan Keluarga</label>
                <select name="hub_keluarga" class="form-control" required>
                    <option value="">--Pilih Hubungan Keluarga--</option>
                    {{-- @foreach($data as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach --}}
                </select>
                @error('hub_keluarga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>TPS</label>
                <input type="number" class="form-control" name="tps" id="tps" placeholder="Masukan TPS" value="{{ old('tps') }}" required>
                @error('tps')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Kelurahan</label>
                <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Masukan Kelurahan" value="{{ old('kelurahan') }}" required>
                @error('kelurahan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Nama Penanggung Jawab</label>
                <input type="text" class="form-control" name="nama_pj" id="nama_pj" placeholder="Masukan Nama Penanggung Jawab" value="{{ old('nama_pj') }}" required>
                @error('nama_pj')
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
{{-- @foreach ($data as $item)     --}}
{{-- editdata-{{ $item->id }} untuk di id --}}
{{-- aria-labelledby="editdata-{{ $item->id }} --}}
<div class="modal fade" id="editdata" tabindex="-1" role="dialog" aria-labelledby="editdata" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data pemilih</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="form-group">
                <label>Nama Pemilh</label>
                <input type="text" name="nama_pemilih" id="nama_pemilih" placeholder="Masukan Nama Pemilih" class="form-control" value="" required>
                @error('nama_pemilih')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>NIK</label>
                <input type="text" class="form-control" name="NIK" id="NIK" placeholder="Masukan NIK" value="" required>
                @error('NIK')
                    <small class="text-danger"></small>
                @enderror
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukan Nomor Handphone" value="" required>
                @error('no_hp')
                    <small class="text-danger"></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="hub_keluarga">Hubungan Keluarga</label>
                <select name="hub_keluarga" class="form-control" required>
                    <option value="">--Pilih Hubungan Keluarga--</option>
                    {{-- @foreach($data as $p) --}}
                        <option value="">suami</option>
                        <option value="">istri</option>
                        <option value="">anak</option>
                    {{-- @endforeach --}}
                </select>
                @error('hub_keluarga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>TPS</label>
                <input type="text" class="form-control" name="tps" id="tps" placeholder="Masukan TPS" value="" required>
                @error('tps')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Kelurahan</label>
                <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Masukan Kelurahan" value="" required>
                @error('kelurahan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Nama Penanggung Jawab</label>
                <input type="text" class="form-control" name="nama_pj" id="nama_pj" placeholder="Masukan Nama Penanggung Jawab" value="" required>
                @error('nama_pj')
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
{{-- @endforeach --}}

{{-- modal upload data excel  --}}
<div class="modal fade" id="UploadExcel" tabindex="-1" role="dialog" aria-labelledby="UploadExcel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="modal-body">
          <div class="form-group">
              <label>Upload Data Excel</label>
              <input type="file" name="upload" id="upload" class="form-control" value="{{ old('upload') }}" required>
              @error('upload')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
        </div>
        <div class="modal-footer ">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection