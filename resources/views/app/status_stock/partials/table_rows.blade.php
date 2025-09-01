@forelse($statusStocks as $i => $stock)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $stock->fishType->name ?? '-' }}</td>
        <td>{{ $stock->fma }}</td>
        <td>{{ $stock->bilangan_stok }}</td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">Tiada data</td>
    </tr>
@endforelse 