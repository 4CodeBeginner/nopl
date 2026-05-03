@forelse($sales as $i => $sale)
    <tr>

        <td class="fw-semibold">{{ $i + 1 }}</td>

        <td>
            {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
            <br>
            <small class="text-muted">
                {{ \Carbon\Carbon::parse($sale->sale_date)->format('H:i') }}
            </small>
        </td>

        <!-- CUSTOMER -->
        <td class="customer-name">
            {{ $sale->customer_name ?? '-' }}
        </td>

        <!-- RESI -->
        <td class="resi">
            {{ $sale->tracking_number ?? '-' }}
        </td>

        <!-- TOTAL -->
        <td class="total-col">
            Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
        </td>

        <!-- DETAIL -->
        <td>
            <button class="btn btn-sm toggle-detail d-flex align-items-center gap-2 mx-auto"
                onclick='showDetail({
                    tanggal: "{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y H:i') }}",
                    customer: "{{ $sale->customer_name ?? '-' }}",
                    resi: "{{ $sale->tracking_number ?? '-' }}",
                    total: "Rp {{ number_format($sale->total_amount, 0, ',', '.') }}",
                    details: [
                        @foreach ($sale->details as $d)
                        {
                            produk: "{{ $d->product->name_product }}",
                            qty: "{{ $d->quantity }}",
                            harga: "Rp {{ number_format($d->price, 0, ',', '.') }}",
                            subtotal: "Rp {{ number_format($d->subtotal, 0, ',', '.') }}"
                        }, @endforeach
                    ]
                })'>

                <i class="bi bi-eye"></i>
                <span>Detail</span>

            </button>
        </td>

        <!-- AKSI -->
        <td>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                    Hapus
                </button>
            </form>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center text-muted py-4">
            Belum ada data penjualan
        </td>
    </tr>
@endforelse
