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

        var paketId = $(this).data('id');
        var modal = $('#formModal');

        $('#formModalLabel').text('Edit Paket');

        $.ajax({
            url: BASE_URL + 'paket/' + paketId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#id').val(response.id);
                $('#judul').val(response.judul);
                $('#kategori').val(response.kategori).trigger('change');
                $('#tipe').val(response.tipe).trigger('change');
                $('#harga').val(response.harga);

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

        var paketId = $(this).data('id');

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
                    url: BASE_URL + 'hapus-paket/' + paketId,
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
        $('#formModalLabel').text("Tambah Paket");
        $('#kategori, #tipe').val(null).trigger('change');
    });
</script>