@extends('main')

@section('konten')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Penanggung Jawab</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="section-title">Data Penanggung Jawab</h2>
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
                                            <option value="{{ route('pj.index') }}?size=50"
                                                @if ($selected_size == 50) selected @endif>50</option>
                                            <option value="{{ route('pj.index') }}?size=100"
                                                @if ($selected_size == 100) selected @endif>100</option>
                                            <option value="{{ route('pj.index') }}?size=200"
                                                @if ($selected_size == 200) selected @endif>200</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <form id="search-form" method="GET" action="{{ route('pj.index') }}">
                                            <label for="Pencarian Data">Pencarian Data</label>
                                            <div class="d-flex flex-row">
                                                <input type="text" name="search" class="form-control" id="searchInput"
                                                    value="{{ $search }}" placeholder="Masukkan nama...">
                                                <button type="submit" class="btn btn-success ml-2"><i class="fa fa-search"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                            <div class="suggestions w-25" id="suggestions" style="display: none;"></div>
                                        </form>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-left">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama Penanggung Jawab</th>
                                                <th scope="col">No. HP</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $number = ($data->currentPage() - 1) * $selected_size + 1;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr class="text-left">
                                                    <td>{{ $number }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->no_hp }}</td>
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


    <script>
        document.getElementById('showEntries').addEventListener('change', function(event) {
            var selectedValue = event.target.value;
            if (selectedValue) {
                window.location.href = selectedValue;
            }
        });
    </script>

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
