@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h5 class="text-xl font-semibold text-gray-800">Daftar Distribusi Produk</h5>
            <a href="{{ route('distributions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Distribusi
            </a>
        </div>

        <div class="p-6">
            <table class="min-w-full divide-y divide-gray-200" id="distributions-table">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Distribusi</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barista</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quantity</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimasi Penjualan</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="detailModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:max-w-3xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h5 class="text-xl font-semibold text-gray-900">Detail Distribusi</h5>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="document.getElementById('detailModal').classList.add('hidden')">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="mt-2">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody id="detail-body" class="bg-white divide-y divide-gray-200">
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
        ajax: '{{ route("distributions.data") }}',
        columns: [
            {data: 'date', name: 'date'},
            {data: 'barista_name', name: 'barista_name'},
            {data: 'total_qty', name: 'total_qty'},
            {data: 'estimated_result', name: 'estimated_result'},
            {data: 'notes', name: 'notes'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "pagingType": "full_numbers",
        "dom": 'lfrtBip',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
        }
    });

    // Handle Detail Button Click
    $('#distributions-table').on('click', '.detail-btn', function() {
        var id = $(this).data('id');
        $.get('/distributions/' + id + '/detail', function(data) {
            var html = '';
            data.details.forEach(function(detail) {
                html += '<tr>' +
                    '<td class="px-6 py-4 whitespace-nowrap">' + detail.product.name + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap">Rp ' + detail.price.toLocaleString('id-ID') + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap">' + detail.qty + '</td>' +
                    '<td class="px-6 py-4 whitespace-nowrap">Rp ' + detail.total.toLocaleString('id-ID') + '</td>' +
                    '</tr>';
            });
            $('#detail-body').html(html);
            document.getElementById('detailModal').classList.remove('hidden');
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
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/distributions/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire(
                            'Dihapus!',
                            'Data telah dihapus.',
                            'success'
                        );
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endpush 