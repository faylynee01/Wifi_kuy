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

        $('#formModalLabel').text('Edit Pengguna');

        $.ajax({
            url: BASE_URL + 'pengguna/' + paketId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#id').val(response.id);
                $('#nama').val(response.nama);
                $('#email').val(response.email);
                $('#password').attr('placeholder', 'Isi jika perubahan password');
                $('#role').val(response.role).trigger('change');

                // Show the modal
                modal.modal('show');
            },
            error: function(error) {
                console.error('Error fetching paket data:', error);
                Swal.fire('Request failed', 'Failed to fetch data.', 'warning');
            }
        });
    });

    $('.btnHapus').on('click', function(event) {
        event.preventDefault();

        var paketId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the selected data.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'hapus-pengguna/' + paketId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            Swal.fire('Error', 'Failed to delete the data.', 'error');
                        }
                    },
                    error: function(error) {
                        console.error('Error deleting data:', error);
                        Swal.fire('Request failed', 'Failed to delete the data.', 'warning');
                    }
                });
            }
        });
    });


    $('#formModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('#formModalLabel').text("Tambah Pengguna");
        $('#role').val(null).trigger('change');
        $('#password').attr('placeholder', '');

    });
</script>