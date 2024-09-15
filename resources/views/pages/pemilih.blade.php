@extends('main')

@section('konten')

<div class="main-content">
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
        <h2 class="section-title">Data Pemlih</h2>
        <p class="section-lead">
          Data Pemilih. Anda sebagai admin bisa memodifikasinya.
        </p>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Data Pemlih</h4>
                  
                <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#Tambahdata">
                  <i class="fa fa-plus"></i>Tambah Data
                </button>
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
                
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>                                 
                      <tr class="text-center">
                        <th>No</th>
                        <th>Nama pemilih</th>
                        <th>NIK</th>
                        <th>No. HP</th>
                        <th>Hub. Keluarga</th>
                        <th>TPS</th>
                        <th>Kelurahan</th>
                        <th>Nama PJ</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{-- @foreach ($data as $item)
                      <tr class="text-center align-item-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_pemilih }}</td>
                        <td>{{ $item->NIK }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->hub_keluarga }}</td>
                        <td>{{ $item->tps }}</td>
                        <td>{{ $item->kelurahan }}</td>
                        <td>{{ $item->nama_pj }}</td>
                        <td>
                          <a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editdata-{{ $item->id }}"><i class="far fa-edit"></i></a>
                          <form action="#" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i class="fas fa-times"></i></button>
                          </form>
                        </td>
                      </tr>
                      @endforeach                                --}}
                    </tbody>
                  </table>
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
{{-- @foreach ($data as $item)    
<div class="modal fade" id="editdata-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editdata-{{ $item->id }}" aria-hidden="true">
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
          @method('PUT')
          <div class="modal-body">
            <div class="form-group">
                <label>Nama Pemilh</label>
                <input type="text" name="nama_pemilih" id="nama_pemilih" placeholder="Masukan Nama Pemilih" class="form-control" value="{{ $item->nama_pemilih }}" required>
                @error('nama_pemilih')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>NIK</label>
                <input type="text" class="form-control" name="NIK" id="NIK" placeholder="Masukan NIK" value="{{ $item->NIK }}" required>
                @error('NIK')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukan Nomor Handphone" value="{{ $item->no_hp }}" required>
                @error('no_hp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="hub_keluarga">Hubungan Keluarga</label>
                <select name="hub_keluarga" class="form-control" required>
                    <option value="">--Pilih Hubungan Keluarga--</option>
                    @foreach($data as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
                @error('hub_keluarga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>TPS</label>
                <input type="number" class="form-control" name="tps" id="tps" placeholder="Masukan TPS" value="{{ $item->tps }}" required>
                @error('tps')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Kelurahan</label>
                <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Masukan Kelurahan" value="{{ $item->kelurahan }}" required>
                @error('kelurahan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Nama Penanggung Jawab</label>
                <input type="text" class="form-control" name="nama_pj" id="nama_pj" placeholder="Masukan Nama Penanggung Jawab" value="{{ $item->nama_pj }}" required>
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
@endforeach --}}




@endsection