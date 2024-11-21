<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kelola Paket</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Kelola Paket
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

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Tambah Paket</button>

                        <div class="py-2">
                            <div class="table-responsive">
                                <table class="table dtable border">
                                    <thead class="table-light fw-bold">
                                        <tr>
                                            <td style="text-align:left !important;">#</td>
                                            <td>Judul</td>
                                            <td>Kategori</td>
                                            <td>Tipe</td>
                                            <td>Harga</td>
                                            <td>Opsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1;
                                        foreach ($data['pakets'] as $paket): ?>
                                            <tr>
                                                <td style="text-align:left !important;"><?= $index++ ?></td>
                                                <td><?= $paket['judul'] ?></td>
                                                <td><?= $paket['kategori'] ?></td>
                                                <td><?= $paket['tipe'] ?></td>
                                                <td>Rp. <?= number_format($paket['harga'], 0, ',', '.') ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btnEdit btn btn-sm btn-warning" data-id="<?= $paket['id'] ?>" aria-label="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button class="btnHapus btn btn-sm btn-danger" data-id="<?= $paket['id'] ?>" aria-label="Hapus">
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
                <h5 class="modal-title" id="formModalLabel">Tambah Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASE_URL . 'simpan-paket' ?>" method="post" id="formData" class="row g-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value=""></option>
                            <option value="10 Mbps">10 Mbps</option>
                            <option value="20 Mbps">20 Mbps</option>
                            <option value="30 Mbps">30 Mbps</option>
                            <option value="40 Mbps">40 Mbps</option>
                            <option value="50 Mbps">50 Mbps</option>
                            <option value="60 Mbps">60 Mbps</option>
                            <option value="70 Mbps">70 Mbps</option>
                            <option value="80 Mbps">80 Mbps</option>
                            <option value="90 Mbps">90 Mbps</option>
                            <option value="100 Mbps">100 Mbps</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipe</label>
                        <select name="tipe" id="tipe" class="form-select">
                            <option value=""></option>
                            <option value="Harian">Harian</option>
                            <option value="Mingguan">Mingguan</option>
                            <option value="Bulanan">Bulanan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control">
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