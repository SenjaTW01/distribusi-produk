@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h5 class="text-xl font-semibold text-gray-800">Tambah Distribusi Baru</h5>
        </div>

        <div class="p-6">
            <form id="distribution-form" method="POST" action="{{ route('distributions.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="barista_id" class="block text-gray-700 text-sm font-bold mb-2">Barista</label>
                    <select name="barista_id" id="barista_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('barista_id') border-red-500 @enderror" required>
                        <option value="">Pilih Barista</option>
                        @foreach($baristas as $barista)
                            <option value="{{ $barista->id }}" {{ old('barista_id') == $barista->id ? 'selected' : '' }}>
                                {{ $barista->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barista_id')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan</label>
                    <textarea name="notes" id="notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('notes') border-red-500 @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6 border-gray-300">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Produk</label>
                        <select name="product_id" id="product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Produk</option>
                        </select>
                    </div>
                    <div>
                        <label for="qty" class="block text-gray-700 text-sm font-bold mb-2">Jumlah</label>
                        <input type="number" name="qty" id="qty" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1">
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="add-product" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Tambah Produk</button>
                    </div>
                </div>

                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200" id="products-table">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                <th id="total-qty" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">0</th>
                                <th id="total-price" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp 0</th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" id="submit-btn" disabled>Simpan Distribusi</button>
                    <a href="{{ route('distributions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // Load available products
    function loadProducts() {
        $.get('{{ route("products.available") }}', function(data) {
            var options = '<option value="">Pilih Produk</option>';
            data.forEach(function(product) {
                options += '<option value="' + product.id + '" data-price="' + product.price + '">' + product.name + '</option>';
            });
            $('#product_id').html(options);
        });
    }

    // Add product to table
    $('#add-product').click(function() {
        var productId = $('#product_id').val();
        var qty = $('#qty').val();

        if (!productId || !qty || qty <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Pilih produk dan masukkan jumlah yang valid!',
            });
            return;
        }

        $.ajax({
            url: '{{ route("distribution-products.store") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                qty: qty
            },
            success: function(response) {
                if (response.success) {
                    var detail = response.data;
                    var row = '<tr data-id="' + detail.id + '">' +
                        '<td class="px-6 py-4 whitespace-nowrap">' + detail.product.name + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap">Rp ' + detail.price.toLocaleString('id-ID') + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap">' + detail.qty + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap">Rp ' + detail.total.toLocaleString('id-ID') + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap"><button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs remove-product">Hapus</button></td>' +
                        '</tr>';

                    $('#products-table tbody').append(row);
                    updateTotals();
                    $('#product_id').val('');
                    $('#qty').val('');
                    Swal.fire(
                        'Berhasil!',
                        'Produk berhasil ditambahkan.',
                        'success'
                    );
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                });
            }
        });
        updateSubmitButton();
    });

    // Remove product from table
    $(document).on('click', '.remove-product', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Produk ini akan dihapus dari daftar sementara!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/distribution-products/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            updateTotals();
                            Swal.fire(
                                'Dihapus!',
                                'Produk berhasil dihapus.',
                                'success'
                            );
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                        });
                    }
                });
            }
        });
        updateSubmitButton();
    });

    // Update totals
    function updateTotals() {
        var totalQty = 0;
        var totalPrice = 0;

        $('#products-table tbody tr').each(function() {
            var qty = parseInt($(this).find('td:eq(2)').text());
            var priceText = $(this).find('td:eq(1)').text().replace(/[^0-9,]/g, ''); // Keep commas for toLocaleString
            var price = parseInt(priceText.replace(/\./g, '').replace(/,/g, '')); // Parse without dots and commas

            totalQty += qty;
            totalPrice += (qty * price);
        });

        $('#total-qty').text(totalQty);
        $('#total-price').text('Rp ' + totalPrice.toLocaleString('id-ID'));
    }

    // Enable/disable submit button based on products table
    function updateSubmitButton() {
        var hasProducts = $('#products-table tbody tr').length > 0;
        $('#submit-btn').prop('disabled', !hasProducts);
    }

    // Load products on page load
    loadProducts();

    // Initial check
    updateSubmitButton();
});
</script>
@endpush 