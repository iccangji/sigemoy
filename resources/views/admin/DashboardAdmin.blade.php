@extends('partials.mainberanda')

@section('konten')



<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data KPU</h4>
                        </div>
                        <div class="card-body">
                            10
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Pemilih</h4>
                        </div>
                        <div class="card-body">
                            42
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-copy"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Ganda</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-xmark"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Tidak Valid</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div>                  
        </div>

        <!-- Chart container -->
        <div class="card">
            <div class="card-header">
                <h3>Statistik Data Pemilih Yang Sudah di Validasi</h3>
            </div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
            <div class="footer align-items-center mb-5" style="display: flex; justify-content: center;">
                <button class="btn btn-warning" id="backButton" onclick="goBack()" style="display: none;"><i class="fa-solid fa-backward"></i> Kembali</button>
            </div>
        </div>
        
        
        

    </section>
</div>

<script>
    

        // Data Structure: Nested Kecamatan -> Kelurahan -> TPS with voters data
        const data = {
            "Kecamatan A": { // Kecamatan existing
                kelurahan: {
                    "Kelurahan A1": { 
                        tps: [
                            { name: "TPS 1", pemilih: 150 },
                            { name: "TPS 2", pemilih: 200 },
                            { name: "TPS 3", pemilih: 180 }
                        ]
                    },
                    "Kelurahan A2": { 
                        tps: [
                            { name: "TPS 4", pemilih: 220 },
                            { name: "TPS 5", pemilih: 170 }
                        ]
                    }
                    // Potentially add more Kelurahan here...
                }
            },
            "Kecamatan B": { // Kecamatan existing
                kelurahan: {
                    "Kelurahan B1": { 
                        tps: [
                            { name: "TPS 6", pemilih: 130 },
                            { name: "TPS 7", pemilih: 190 }
                        ]
                    },
                    "Kelurahan B2": { 
                        tps: [
                            { name: "TPS 8", pemilih: 210 },
                            { name: "TPS 9", pemilih: 160 },
                            { name: "TPS 10", pemilih: 140 }
                        ]
                    }
                    // Potentially add more Kelurahan here...
                }
            },
            // Adding new Kecamatan with multiple Kelurahan
            ...Array.from({ length: 9 }, (_, i) => {
                return {
                    [`Kecamatan ${String.fromCharCode(67 + i)}`]: {
                        kelurahan: Object.fromEntries(
                            Array.from({ length: Math.floor(Math.random() * 6) + 5 }, (__, k) => [
                                `Kelurahan ${String.fromCharCode(67 + i)}${k + 1}`, {
                                    tps: Array.from({ length: Math.floor(Math.random() * 5) + 3 }, (___, t) => ({
                                        name: `TPS ${t + 1}`,
                                        pemilih: Math.floor(Math.random() * 100) + 100
                                    }))
                                }
                            ])
                        )
                    }
                };
            }).reduce((acc, curr) => ({ ...acc, ...curr }), {})
        };


    // Function to generate random colors
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const randomColor = `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`;
            colors.push(randomColor);
        }
        return colors;
    }

    // Function to calculate total voters in each Kelurahan
    function calculateTotalVotersInKelurahan(kelurahanData) {
        return kelurahanData.tps.reduce((total, tps) => total + tps.pemilih, 0);
    }

    // Function to calculate total voters in each Kecamatan
    function calculateTotalVotersInKecamatan(kecamatanData) {
        const kelurahanKeys = Object.keys(kecamatanData.kelurahan);
        return kelurahanKeys.reduce((total, kelurahanKey) => {
            const kelurahanData = kecamatanData.kelurahan[kelurahanKey];
            return total + calculateTotalVotersInKelurahan(kelurahanData);
        }, 0);
    }

    // Initial State: Show total voters for each Kecamatan
    let chartData = {
        labels: Object.keys(data), // Kecamatan names
        datasets: [{
            label: 'Kecamatan',
            data: Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan])), // Calculate total voters for each Kecamatan
            backgroundColor: generateColors(Object.keys(data).length), // Generate random colors
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };


    // Initial State: Show total voters for each Kecamatan with updated labels
    const totalVotersPerKecamatan = Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan]));
    chartData.labels = Object.keys(data).map((kecamatan, index) => `${kecamatan} (${totalVotersPerKecamatan[index]} Pemilih)`);

    // Setelah itu, kode untuk menginisialisasi chart tetap sama
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        usePointStyle: true,
                        color: 'transparent',
                        font: {
                            size: 14,
                        },
                        generateLabels: function(chart) {
                            return chart.data.datasets.map(function(dataset, i) {
                                return {
                                    text: dataset.label,
                                    fillStyle: 'transparent',
                                    strokeStyle: 'transparent',
                                    hidden: !chart.isDatasetVisible(i),
                                    lineCap: 'round',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'round',
                                    lineWidth: 0,
                                    strokeStyle: 'transparent',
                                    pointStyle: 'rectRounded',
                                    rotation: 0
                                };
                            });
                        }
                    }
                }
            },
            onClick: (e) => {
                    const activePoint = myChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);
                    if (activePoint.length > 0) {
                        const clickedIndex = activePoint[0].index;  // Mendapatkan indeks item yang diklik
                        // Mengambil hanya nama kecamatan dari label yang diklik
                        const currentLabel = chartData.labels[clickedIndex].split(' (')[0]; // Memisahkan nama kecamatan dari jumlah pemilih

                        if (chartData.datasets[0].label === 'Kecamatan') {
                            // Jika Kecamatan diklik, perbarui untuk menampilkan Kelurahan
                            updateKelurahan(currentLabel);
                        } else if (chartData.datasets[0].label === 'Kelurahan') {
                            // Jika Kelurahan diklik, perbarui untuk menampilkan TPS
                            updateTPS(currentLabel);
                        }
                    }
                },

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Definisikan currentState sebagai objek global
    var currentState = {
        kecamatan: null,
        kelurahan: null,
        tps: null
    };



    function updateKecamatan() {
        let totalVotersPerKecamatan = Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan]));
        chartData.labels = Object.keys(data).map((kecamatan, index) => `${kecamatan} (${totalVotersPerKecamatan[index]} Pemilih)`);
        chartData.datasets[0].data = totalVotersPerKecamatan;
        chartData.datasets[0].label = 'Kecamatan';
        chartData.datasets[0].backgroundColor = generateColors(Object.keys(data).length);

        myChart.update();
        document.getElementById('backButton').style.display = 'none';
    }

    function goBack() {
        const currentLabelType = myChart.config.data.datasets[0].label;

        if (currentLabelType === 'TPS') {
            // Mendapatkan kelurahan dari state saat ini (asumsikan state ini diperbarui ketika masuk ke view TPS)
            const kelurahanAktif = currentState.kelurahan; // Gunakan state yang tersimpan saat view TPS diaktifkan
            const kecamatanAktif = currentState.kecamatan; // Asumsi kita simpan nama kecamatan juga saat masuk ke view TPS

            if (!kelurahanAktif || !kecamatanAktif) {
                console.error('Error: Kelurahan or Kecamatan data is missing');
                return; // Keluar dari fungsi jika tidak ada data kelurahan atau kecamatan
            }

            updateKelurahan(kecamatanAktif, kelurahanAktif);
        } else if (currentLabelType === 'Kelurahan') {
            updateKecamatan();
        }

        // Mengatur kapan tombol kembali harus disembunyikan atau ditampilkan
        if (currentLabelType === 'Kecamatan') {
            document.getElementById('backButton').style.display = 'none';
        } else {
            document.getElementById('backButton').style.display = 'block';
        }
    }


    

    // Update chart to display Kelurahan for the selected Kecamatan
    function updateKelurahan(kecamatan) {
        const kelurahanData = Object.keys(data[kecamatan].kelurahan);
        const totalVotersPerKelurahan = kelurahanData.map(kelurahan => calculateTotalVotersInKelurahan(data[kecamatan].kelurahan[kelurahan]));
        
        // Memperbarui label dengan jumlah pemilih
        chartData.labels = kelurahanData.map(kelurahan => `${kelurahan} (${totalVotersPerKelurahan[kelurahanData.indexOf(kelurahan)]} Pemilih)`);
        chartData.datasets[0].label = 'Kelurahan';
        chartData.datasets[0].data = totalVotersPerKelurahan; // Menggunakan total pemilih sebagai data
        chartData.datasets[0].backgroundColor = generateColors(kelurahanData.length); // Menghasilkan warna acak
        
        myChart.update();

        document.getElementById('backButton').style.display = 'block'; // Memperlihatkan tombol kembali
    }


    // Update chart to display TPS for the selected Kelurahan
    function updateTPS(kelurahan) {
        let currentKecamatan = '';
        for (let kec in data) {
            if (data[kec].kelurahan[kelurahan]) {
                currentKecamatan = kec;
                break;
            }
        }

        if (!currentKecamatan) {
            console.error("Kelurahan not found:", kelurahan);
            return;
        }

        const tpsData = data[currentKecamatan].kelurahan[kelurahan].tps;
        chartData.labels = tpsData.map(tps => `${tps.name} (${tps.pemilih} Pemilih)`);
        chartData.datasets[0].label = 'TPS';
        chartData.datasets[0].data = tpsData.map(tps => tps.pemilih);
        chartData.datasets[0].backgroundColor = generateColors(tpsData.length);

        myChart.update();
        document.getElementById('backButton').style.display = 'block';

        // Update currentState for navigation
        currentState.kecamatan = currentKecamatan;
        currentState.kelurahan = kelurahan;
    }



</script>


@endsection
