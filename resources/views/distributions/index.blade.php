@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section dengan Card Effect -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-blue-50 to-white">
            <h5 class="text-xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Daftar Distribusi Produk
            </h5>
            <a href="{{ route('distributions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Distribusi
            </a>
        </div>

        <!-- DataTable Container dengan Styling yang Lebih Modern -->
        <div class="p-6">
            <!-- Custom Filters Section -->
            <div class="bg-white rounded-lg p-6 mb-6 shadow-sm border border-gray-100">
                <h6 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Distribusi
                </h6>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" id="start_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" id="end_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label for="min_sales" class="block text-sm font-medium text-gray-700 mb-1">Min Penjualan (Rp)</label>
                        <input type="number" id="min_sales" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-3 text-gray-700" placeholder="Misal: 10000">
                    </div>
                    <div>
                        <label for="max_sales" class="block text-sm font-medium text-gray-700 mb-1">Max Penjualan (Rp)</label>
                        <input type="number" id="max_sales" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-2 px-3 text-gray-700" placeholder="Misal: 500000">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button id="apply-filter" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-md transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Terapkan Filter
                    </button>
                    <button id="clear-filter" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md shadow-md transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Bersihkan Filter
                    </button>
                </div>
            </div>

            <!-- Search & Length Control Styling -->
            <style>
                .dataTables_wrapper .dataTables_length select {
                    @apply border border-gray-300 text-gray-700 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
                }
                .dataTables_wrapper .dataTables_filter input {
                    @apply border border-gray-300 text-gray-700 rounded-md py-1.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 ml-2;
                }
                .dataTables_wrapper .dataTables_paginate .paginate_button {
                    @apply px-3 py-1.5 border border-gray-200 mx-1 rounded-md text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200;
                }
                .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                    @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:text-white hover:border-blue-700;
                }
                .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
                    @apply text-gray-400 border-gray-100 hover:bg-transparent hover:text-gray-400;
                }
                .dataTables_wrapper .dataTables_info {
                    @apply text-sm text-gray-600 py-2;
                }
                /* Hover effect untuk baris tabel */
                #distributions-table tbody tr:hover {
                    @apply bg-blue-50;
                }
                /* Styling untuk label pencarian global */
                .dataTables_wrapper .dataTables_filter label {
                    @apply text-gray-700 font-medium;
                }
                /* Styling untuk label show entries */
                .dataTables_wrapper .dataTables_length label {
                    @apply text-gray-700 font-medium;
                }
            </style>
            
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="distributions-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tl-lg">Tanggal Distribusi</th>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barista</th>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Quantity</th>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estimasi Penjualan</th>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3.5 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail dengan Desain Modern -->
<div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300" id="detailModal">
    <div class="relative top-20 mx-auto p-6 border w-11/12 md:max-w-3xl shadow-2xl rounded-xl bg-white transition-all duration-300 transform">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
            <h5 class="text-xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Detail Distribusi
            </h5>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center transition duration-200" onclick="document.getElementById('detailModal').classList.add('hidden')">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="mt-4">
            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-6 py-3.5 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3.5 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3.5 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3.5 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody id="detail-body" class="bg-white divide-y divide-gray-100">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var table = $('#distributions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("distributions.data") }}',
            data: function (d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                d.min_sales = $('#min_sales').val();
                d.max_sales = $('#max_sales').val();
            }
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'barista_name', name: 'barista_name'},
            {data: 'total_qty', name: 'total_qty'},
            {data: 'estimated_result', name: 'estimated_result',
             render: function(data) {
                 var value = parseFloat(data);
                 
                 var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return '<span class="font-medium text-green-600">' + formatter.format(value) + '</span>';
             }
            },
            {data: 'notes', name: 'notes'},
            {data: 'action', name: 'action', orderable: false, searchable: false,
             render: function(data, type, row) {
                 // Membuat tombol aksi yang lebih modern
                 return '<div class="flex space-x-2">' +
                     '<button data-id="' + row.id + '" class="detail-btn bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-1.5 px-3 rounded-md transition duration-200 flex items-center">' +
                     '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                     '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />' +
                     '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />' +
                     '</svg>Detail</button>' +
                     '<button data-id="' + row.id + '" class="delete-btn bg-red-100 hover:bg-red-200 text-red-700 font-medium py-1.5 px-3 rounded-md transition duration-200 flex items-center">' +
                     '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                     '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />' +
                     '</svg>Hapus</button>' +
                     '</div>';
             }
            }
        ],
        "pagingType": "full_numbers",
        "dom": 'lfrtBip',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
        },
        "drawCallback": function() {
            // Menambahkan class untuk styling yang lebih baik
            $('.dataTables_wrapper').addClass('rounded-lg overflow-hidden');
            $('.dataTables_paginate').addClass('py-3');
        }
    });

    // Apply Filter Button Click
    $('#apply-filter').on('click', function() {
        table.ajax.reload();
    });

    // Clear Filter Button Click
    $('#clear-filter').on('click', function() {
        $('#start_date').val('');
        $('#end_date').val('');
        $('#min_sales').val('');
        $('#max_sales').val('');
        table.ajax.reload();
    });

    // Handle Detail Button Click
    $('#distributions-table').on('click', '.detail-btn', function() {
        var id = $(this).data('id');
        $.get('/distributions/' + id + '/detail', function(data) {
            var html = '';
            data.details.forEach(function(detail) {
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                var formattedPrice = formatter.format(parseFloat(detail.price));
                var formattedTotal = formatter.format(parseFloat(detail.total));

                html += '<tr class="hover:bg-gray-50">' +
                    '<td class="px-6 py-4 whitespace-nowrap text-gray-800">' + detail.product.name + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">' + formattedPrice + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">' + detail.qty + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">' + formattedTotal + '</td>' +
                    '</tr>';
            });
            $('#detail-body').html(html);
            
            // Animasi modal saat dibuka
            var modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            setTimeout(function() {
                modal.querySelector('.relative').classList.add('scale-100');
                modal.querySelector('.relative').classList.remove('scale-95');
            }, 10);
        });
    });

    // Handle Delete Button Click
    $('#distributions-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md shadow-sm',
                cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm mr-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/distributions/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Dihapus!',
                            text: 'Data telah dihapus.',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm'
                            },
                            buttonsStyling: false
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        var errorMessage = 'Terjadi kesalahan saat menghapus data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush