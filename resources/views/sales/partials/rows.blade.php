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

        <td>
            <div class="customer-name">{{ $sale->customer_name ?? '-' }}</div>
            <div class="resi">Resi: {{ $sale->tracking_number ?? '-' }}</div>
        </td>

        <td>
            <table class="table nested-table mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($sale->details as $d)
                        <tr>
                            <td class="text-start">{{ $d->product->name_product }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td>Rp {{ number_format($d->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </td>

        <td class="total-text price-col">
            Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
        </td>

        <td>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            Tidak ada data
        </td>
    </tr>
@endforelse
