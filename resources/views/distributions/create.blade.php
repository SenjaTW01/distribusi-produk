@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 border-b border-gray-200">
            <h5 class="text-xl font-semibold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Distribusi Baru
            </h5>
        </div>

        <div class="p-6">
            <form id="distribution-form" method="POST" action="{{ route('distributions.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="barista_id" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Barista
                    </label>
                    <div class="relative">
                        <select name="barista_id" id="barista_id" class="appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-lg w-full leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('barista_id') border-red-500 @enderror" required>
                            <option value="">Pilih Barista</option>
                            @foreach($baristas as $barista)
                                <option value="{{ $barista->id }}" {{ old('barista_id') == $barista->id ? 'selected' : '' }}>
                                    {{ $barista->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                    @error('barista_id')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Catatan
                    </label>
                    <textarea name="notes" id="notes" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('notes') border-red-500 @enderror" rows="2">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500 font-medium">Detail Produk</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Produk
                        </label>
                        <div class="relative">
                            <select name="product_id" id="product_id" class="appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-lg w-full leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Produk</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="qty" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Jumlah
                        </label>
                        <div class="relative">
                            <input type="number" name="qty" id="qty" class="bg-gray-50 border border-gray-300 text-gray-700 py-2 px-3 rounded-lg w-full leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" min="1">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">pcs</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="add-product" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-4 rounded-lg w-full transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Produk
                        </button>
                    </div>
                </div>

                <div class="overflow-hidden mb-6 rounded-lg shadow-sm border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200" id="products-table">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                        <tfoot>
                            <tr class="bg-gradient-to-r from-blue-50 to-blue-100">
                                <th colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                <th id="total-qty" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">0</th>
                                <th id="total-price" class="px-6 py-3 text-left text-sm font-bold text-blue-700">Rp 0</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:transition-none" id="submit-btn" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Distribusi
                    </button>
                    <a href="{{ route('distributions.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Kembali
                    </a>
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
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
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
                    var row = '<tr data-id="' + detail.id + '" class="hover:bg-gray-50 transition-colors">' +
                        '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' + detail.product.name + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-mono">Rp ' + detail.price.toLocaleString('id-ID') + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">' + detail.qty + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap text-sm text-blue-700 font-semibold font-mono">Rp ' + detail.total.toLocaleString('id-ID') + '</td>' +
                        '<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"><button type="button" class="bg-red-100 text-red-700 hover:bg-red-200 font-medium py-1 px-3 rounded-full text-xs remove-product transition-colors flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>Hapus</button></td>' +
                        '</tr>';

                    $('#products-table tbody').append(row);
                    updateTotals();
                    $('#product_id').val('');
                    $('#qty').val('');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil ditambahkan.',
                        confirmButtonColor: '#10B981',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonColor: '#EF4444'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                    confirmButtonColor: '#EF4444'
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
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger mr-2',
                cancelButton: 'btn btn-secondary'
            }
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Produk berhasil dihapus.',
                                confirmButtonColor: '#10B981',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                confirmButtonColor: '#EF4444'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                            confirmButtonColor: '#EF4444'
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