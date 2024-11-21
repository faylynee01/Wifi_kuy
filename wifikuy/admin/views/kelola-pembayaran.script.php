<script>
    const BASE_URL = "<?= BASE_URL ?>";
    // Initialize DataTable
    new DataTable('.dtable');

    $('.btnSubmit').on('click', function(event) {
        event.preventDefault();

        var formId = 'formData';

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to submit this form?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#' + formId).submit();
            } else {
                Swal.fire('Cancelled', 'The form was not submitted.', 'info');
            }
        });
    });

    $('.btnEdit').on('click', function(event) {
        event.preventDefault();

        var dataId = $(this).data('id');
        var modal = $('#formModal');

        $.ajax({
            url: BASE_URL + 'pembayaran/' + dataId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#id').val(response.id_pembayaran);
                $('#id_paket').val(response.id_paket);
                $('#nama_paket').val(`${response.nama_paket} | ${response.tipe_paket} | ${response.kategori_paket}`);
                $('#id_user').val(response.id_user);
                $('#member').val(`${response.user_name}`);
                $('#tanggal_waktu').val(response.tanggal_waktu);
                $('#bukti_pembayaran').val(response.bukti_pembayaran);
                $('#id_metode_pembayaran').val(response.id_metode_pembayaran);
                $('#metode_pembayaran').val(response.nama_metode);
                $('#status').val(response.status);
                $('#invoice').val(response.invoice);
                $('#alasan').val(response.alasan);
                $('#kode_wifi').val(response.kode_wifi);


                // Show the modal
                modal.modal('show');
            },
            error: function(error) {
                console.error('Error fetching paket data:', error);
                Swal.fire('Request failed', 'Failed to fetch paket data.', 'warning');
            }
        });
    });

    $('.btnHapus').on('click', function(event) {
        event.preventDefault();

        var dataId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the selected package.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'hapus-pembayaran/' + dataId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            Swal.fire('Error', 'Failed to delete the package.', 'error');
                        }
                    },
                    error: function(error) {
                        console.error('Error deleting paket:', error);
                        Swal.fire('Request failed', 'Failed to delete the package.', 'warning');
                    }
                });
            }
        });
    });


    $('#formModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });
</script>