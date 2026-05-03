@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 14px;
            border: none;
        }

        .stat-card {
            padding: 20px;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-title {
            font-size: 14px;
            color: #888;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
        }
    </style>

    <h4 class="mb-4">Dashboard Statistik Penjualan</h4>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Total Omzet</div>
                <div class="stat-value">
                    Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value">
                    {{ $totalTransaksi }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Total Produk Terjual</div>
                <div class="stat-value">
                    {{ $totalQty }}
                </div>
            </div>
        </div>

    </div>

    <br>

    <div class="row">

        <!-- TOP PRODUCT -->
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Produk Terlaris</h5>

                <table class="table table-sm mt-3">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topProducts as $p)
                            <tr>
                                <td>{{ $p->name_product }}</td>
                                <td>{{ $p->total_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <!-- GRAFIK PENJUALAN -->
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Penjualan 7 Hari Terakhir</h5>

                <canvas id="salesChart"></canvas>
            </div>
        </div>

    </div>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesLast7Days->pluck('date')) !!},
                datasets: [{
                    label: 'Penjualan',
                    data: {!! json_encode($salesLast7Days->pluck('total')) !!},
                    borderWidth: 2
                }]
            }
        });
    </script>
@endsection
