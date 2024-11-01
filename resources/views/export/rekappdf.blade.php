<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Data Pemilih</title>
    <style>
        table {
            border-collapse: collapse;
            /* Menggabungkan border */
            width: 100%;
            /* Mengatur lebar tabel */
        }

        th,
        td {
            border: 1px solid black;
            /* Menambahkan border ke sel */
            padding: 10px;
            /* Menambahkan padding */
            text-align: left;
            font-size: 10px;
            /* Mengatur alignment teks */
        }

        th {
            background-color: #d6e9ff;
            /* Warna latar belakang header */
        }

        .badge {
            border-radius: 50%;
            padding: 4px;
            white-space: nowrap;
            display: flex;
            text-align: center
        }

        .badge-danger {
            background-color: rgb(195, 62, 62);
        }

        .badge-success {
            background-color: rgb(62, 195, 91);
        }
    </style>
</head>

<body>
    @if ($search)
        @if ($count_pemilih)
            <h2 style="text-align: center">Data Pemilih YUDHI-NIRNA</h2>
            <div class="d-flex flex-column m-0">
                @foreach ($data_pj as $item)
                    <p>
                        {{ $item->nama }} ({{ $item->no_hp }})
                    </p>
                @endforeach
                <p class="font-weight-bold">Jumlah Keseluruhan Data:
                    {{ $count_pemilih + $count_ganda + $count_invalid }}
                </p>
                <p class="font-weight-bold">Jumlah Data Valid: {{ $count_pemilih }}</p>
                <p class="font-weight-bold">Jumlah Data Ganda: {{ $count_ganda }}</p>
                <p class="font-weight-bold">Jumlah Data Tidak Valid: {{ $count_invalid }}</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" border="1">
                    <thead class="text-center">
                        <tr border="0">
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
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @elseif ($item->status == 'Ganda')
                                        <span class="badge badge-danger">{{ $item->status }}</span>
                                    @elseif ($item->status == 'Tidak Valid')
                                        <span class="badge badge-danger">{{ $item->status }}</span>
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
                                $number += 1;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</body>
