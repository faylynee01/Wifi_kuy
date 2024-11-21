<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Metode Pembayaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Metode Pembayaran
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div> <!--end::App Content Header--> <!--begin::App Content-->
<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row"> <!--begin::Col-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Display success flash message
                        $successMessage = $action->getFlashMessage('success');
                        if ($successMessage) {
                            echo '<div class="alert alert-success">' . htmlspecialchars($successMessage) . '</div>';
                        }

                        // Display failed flash message
                        $failedMessage = $action->getFlashMessage('failed');
                        if ($failedMessage) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($failedMessage) . '</div>';
                        }
                        ?>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Tambah Metode</button>

                        <div class="py-2">
                            <div class="table-responsive">
                                <table class="table dtable border">
                                    <thead class="table-light fw-bold">
                                        <tr>
                                            <td style="text-align:left !important;">#</td>
                                            <td>Nama</td>
                                            <td>Tipe</td>
                                            <td style="text-align:left !important;">Nomor atau Norek</td>
                                            <td>Atas Nama</td>
                                            <td>Opsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1;
                                        foreach ($data['metodes'] as $metode): ?>
                                            <tr>
                                                <td style="text-align:left !important;"><?= $index++ ?></td>
                                                <td><?= $metode['nama'] ?></td>
                                                <td><?= $metode['tipe'] ?></td>
                                                <td style="text-align:left !important;"><?= $metode['nomor_atau_norek'] ?></td>
                                                <td><?= $metode['atas_nama'] ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btnEdit btn btn-sm btn-warning" data-id="<?= $metode['id'] ?>" aria-label="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button class="btnHapus btn btn-sm btn-danger" data-id="<?= $metode['id'] ?>" aria-label="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--end::Row--> <!--begin::Row-->

    </div> <!--end::Container-->
</div> <!--end::App Content-->


<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Metode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASE_URL . 'simpan-metode' ?>" method="post" id="formData" class="row g-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe</label>
                        <select name="tipe" id="tipe" class="form-select">
                            <option value=""></option>
                            <option value="E-wallet">E-wallet</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nomor atau Norek</label>
                        <input type="text" name="nomor_atau_norek" id="nomor_atau_norek" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="atas_nama">Atas nama</label>
                        <input type="text" name="atas_nama" id="atas_nama" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>