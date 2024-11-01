@extends('main')

@section('konten')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Data</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="section-title">Rekap Data</h2>
                                @if ($level != 'viewer')
                                    <div>
                                        <!-- Tombol Upload Excel -->
                                        @if ($search && $count_pemilih)
                                            <a href="{{ route('rekap.export', ['search' => $search]) }}">
                                                <button class="btn btn-outline-danger btn-round mr-2">
                                                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-2 align-items-center">
                                    <div class="form-group d-flex align-items-end flex-column">
                                        <form id="search-form" method="GET" action="{{ $route }}"
                                            autocomplete="off">
                                            <label for="Pencarian Data">Nama Penanggung Jawab</label>
                                            <div class="d-flex flex-row">
                                                <div>
                                                    <input type="text" name="search" class="form-control"
                                                        id="searchInput" value="{{ $search }}"
                                                        placeholder="Masukkan nama PJ...">
                                                </div>
                                                <button type="submit" class="btn btn-success ml-2"><i class="fa fa-search"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                            <div class="suggestions w-25" id="suggestions" style="display: none;">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @if ($search)
                                    @if ($count_pemilih)
                                        <div class="d-flex flex-column m-0">
                                            <p class="font-weight-bold">Jumlah Keseluruhan Data:
                                                {{ $count_pemilih + $count_ganda + $count_invalid }}
                                            </p>
                                            <p class="font-weight-bold">Jumlah Data Valid: {{ $count_pemilih }}</p>
                                            <p class="font-weight-bold">Jumlah Data Ganda: {{ $count_ganda }}</p>
                                            <p class="font-weight-bold">Jumlah Data Tidak Valid: {{ $count_invalid }}</p>
                                            @foreach ($data_pj as $item)
                                                <p>
                                                    {{ $item->nama }} ({{ $item->no_hp }})
                                                </p>
                                            @endforeach
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Nama Pemilih</th>
                                                        <th scope="col">Nama PJ</th>
                                                        <th scope="col">NIK</th>
                                                        <th scope="col">No. HP</th>
                                                        <th scope="col">Hub. Keluarga</th>
                                                        <th scope="col">TPS</th>
                                                        <th scope="col">Kelurahan</th>
                                                        <th scope="col">Kecamatan</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $number = 1;
                                                    @endphp
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $number }}</td>
                                                            <td class="text-center">
                                                                @if ($item->status == 'Valid')
                                                                    <span
                                                                        class="badge badge-success">{{ $item->status }}</span>
                                                                @elseif ($item->status == 'Ganda')
                                                                    <span
                                                                        class="badge badge-danger">{{ $item->status }}</span>
                                                                @elseif ($item->status == 'Tidak Valid')
                                                                    <span
                                                                        class="badge badge-danger">{{ $item->status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->nama }}</td>
                                                            <td>
                                                                @if ($item->nama_pj)
                                                                    {{ $item->nama_pj }}
                                                                @else
                                                                    @php
                                                                        $str = str_replace(
                                                                            'Terdapat irisan data antara penanggung jawab atas nama',
                                                                            '',
                                                                            $item->report,
                                                                        );
                                                                        $str = str_replace('dan', '/', $str);
                                                                        $str = preg_replace('/\([^)]*\)/', '', $str);
                                                                    @endphp
                                                                    {{ $str }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->nik }}</td>
                                                            <td>{{ $item->no_hp }}</td>
                                                            <td>{{ $item->hub_keluarga }}</td>
                                                            <td>{{ $item->tps }}</td>
                                                            <td>{{ $item->kelurahan }}</td>
                                                            <td>{{ $item->kecamatan }}</td>
                                                        </tr>
                                                        @php
                                                            $number++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="footer  d-flex justify-content-between align-items-center">

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">

                                                    <li class="page-item">
                                                        @if ($data->currentPage() > 1)
                                                            <a href="{{ $data->previousPageUrl() }}"
                                                                data-page="{{ $data->currentPage() - 1 }}"
                                                                class="page-link">Previous</a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <a
                                                            class="page-link disabled bordered">{{ $data->currentPage() }}</a>
                                                    </li>
                                                    <li class="page-item">
                                                        @if ($data->hasMorePages())
                                                            <a href="{{ $data->nextPageUrl() }}" class="page-link">Next</a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    @else
                                        <div class="">
                                            <h5 class="text-center py-4">Data tidak ditemukan</h5>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 2) { // Hanya mencari jika panjang input lebih dari 2 karakter
                    $.ajax({
                        url: '/rekap-data-suggestion',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            let suggestions = $('#suggestions');
                            suggestions.empty(); // Kosongkan area suggestion sebelumnya

                            if (data.length) {
                                suggestions.show();
                                data.forEach(function(item) {
                                    suggestions.append('<div class="suggestion-item">' +
                                        item + '</div>');
                                });
                            } else {
                                suggestions.hide();
                            }
                        }
                    });
                } else {
                    $('#suggestions').hide(); // Sembunyikan jika kurang dari 3 karakter
                }
            });

            // Mengatur ketika pengguna mengklik item suggestion
            $(document).on('click', '.suggestion-item', function() {
                $('#searchInput').val($(this).text()); // Isi input dengan teks item yang diklik
                $('#suggestions').hide(); // Sembunyikan suggestion setelah pemilihan
            });
        });
    </script>
@endsection
