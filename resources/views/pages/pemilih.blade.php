@extends('main')

@section('konten')

<div class="main-content"
  @if ($level=='penginput' )
    style="padding-left:20px;"
  @endif>
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
                <button class="btn btn-success btn-round mr-2" data-toggle="modal" data-target="#UploadExcel">
                  <i class="fa fa-file-excel"></i> Upload Excel
                </button>

                <!-- Tombol Tambah Data -->
                <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#Tambahdata">
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
                    <option value="/pemilih?size=50"
                      @if ($selected_size==50)
                      selected
                      @endif>50</option>
                    <option value="/pemilih?size=100"
                      @if ($selected_size==100)
                      selected
                      @endif>100</option>
                    <option value="/pemilih?size=200"
                      @if ($selected_size==200)
                      selected
                      @endif>200</option>
                  </select>
                </div>
                <div class="form-group">
                  <form id="search-form" method="GET" action="./pemilih">
                    <label for="Pencarian Data">Pencarian Data</label>
                    <input type="text" name="search" class="form-control" id="searchInput" value="{{ $search }}" placeholder="Masukkan nama...">
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
                      <th scope="col">Nama PJ</th>
                      @if ($level != 'viewer')
                        <th scope="col">Aksi</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $number = ($current_page-1)*$selected_size + 1;
                    @endphp
                    @foreach ($data as $item)
                    <tr>
                      <td>{{$number}}</td>
                      <td>{{$item->nama}}</td>
                      <td>{{$item->nik}}</td>
                      <td>{{$item->no_hp}}</td>
                      <td>{{$item->hub_keluarga}}</td>
                      <td>{{$item->tps}}</td>
                      <td>{{$item->kelurahan}}</td>
                      <td>{{$item->kecamatan}}</td>
                      <td>{{$item->nama_pj}}</td>
                      @if ($level != 'viewer')
                        <td class="text-center">
                          <a href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#editdata-{{$item->id}}"><i class="far fa-edit"></i></a>
                          <form action="{{ route('pemilih.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')"><i class="fas fa-times"></i></button>
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
                <span>Total {{$count}} Data</span>

                <nav aria-label="Page navigation example">
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
      <form action="/pemilih" method="POST">
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
              <option value="Saudara">Saudara</option>
              <option value="Anak">Anak</option>
              <option value="Suami">Suami</option>
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
            <input type="text" class="form-control" name="tps" id="tps" placeholder="Masukan TPS" value="{{ old('tps') }}" required>
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
@foreach ($data as $item)    
<div class="modal fade" id="editdata-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editdata-{{ $item->id }}" aria-hidden="true">
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
            <input type="text" name="nama_pemilih" id="nama_pemilih" placeholder="Masukan Nama Pemilih" class="form-control" value="{{$item->nama}}" required>
            @error('nama_pemilih')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label>NIK</label>
            <input type="text" class="form-control" name="NIK" id="NIK" placeholder="Masukan NIK" value="{{$item->nik}}" required>
            @error('NIK')
            <small class="text-danger"></small>
            @enderror
          </div>
          <div class="form-group">
            <label>No. HP</label>
            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukan Nomor Handphone" value="{{$item->no_hp}}" required>
            @error('no_hp')
            <small class="text-danger"></small>
            @enderror
          </div>
          <div class="form-group">
            <label for="hub_keluarga">Hubungan Keluarga</label>
            <select name="hub_keluarga" class="form-control" required>
              <option value="">--Pilih Hubungan Keluarga--</option>
              {{-- @foreach($data as $p) --}}
              <option value="suami" @if ($item->hub_keluarga=='suami')
                  selected
              @endif>suami</option>
              <option value="anak" @if ($item->hub_keluarga=='istri')
                selected
            @endif>Istri</option>
              <option value="saudara" @if ($item->hub_keluarga=='saudara')
                selected
            @endif>saudara</option>
              <option value="anak" @if ($item->hub_keluarga=='anak')
                selected
            @endif>anak</option>
              {{-- @endforeach --}}
            </select>
            @error('hub_keluarga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label>TPS</label>
            <input type="text" class="form-control" name="tps" id="tps" placeholder="Masukan TPS" value="{{$item->tps}}" required>
            @error('tps')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label>Kelurahan</label>
            <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Masukan Kelurahan" value="{{$item->kelurahan}}" required>
            @error('kelurahan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" id="kecamatan" disabled placeholder="Masukan Kelurahan" value="{{$item->kelurahan}}" required>
            @error('kecamatan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label>Nama Penanggung Jawab</label>
            <input type="text" class="form-control" name="nama_pj" id="nama_pj" placeholder="Masukan Nama Penanggung Jawab" value="{{$item->nama_pj}}" required>
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
@endforeach

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


  // section pemilih
  $(document).ready(function() {
    // Auto-complete untuk kelurahan
    $('#kelurahan').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '/autocomplete/kelurahan',
                data: {
                    search: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.kelurahan,
                            value: item.kelurahan
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            // Ketika kelurahan dipilih, ambil kecamatan yang sesuai
            const kelurahan = ui.item.value;
            $('#kelurahan').val(kelurahan);
            
            // Disable input kecamatan dan isi data kecamatan yang terkait
            $.ajax({
                url: '/autocomplete/kecamatan',
                data: {
                    kelurahan: kelurahan
                },
                success: function(data) {
                    $('#kecamatan').val(data.kecamatan); // Isi kecamatan terkait
                    $('#kecamatan').prop('disabled', true); // Disable input kecamatan
                }
            });
            
            return false;
        }
    });
});



  
</script>

@endsection