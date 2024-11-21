<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kelola Pembayaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Kelola Pembayaran
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


                        <div class="py-2">
                            <div class="table-responsive">
                                <table class="table dtable border">
                                    <thead class="table-light fw-bold">
                                        <tr>
                                            <td style="text-align:left !important;">#</td>
                                            <td>Invoice</td>
                                            <td>Nama User</td>
                                            <td>Paket</td>
                                            <td>Metode Pembayaran</td>
                                            <td>Bukti Pembayaran</td>
                                            <td style="text-align:center !important;">Tanggal dan Waktu</td>
                                            <td>Status</td>
                                            <td>Opsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1;
                                        foreach ($data['pembayarans'] as $pembayaran): ?>
                                            <tr>
                                                <td style="text-align:left !important;"><?= $index++ ?></td>
                                                <td><?= $pembayaran['invoice'] ?></td>
                                                <td><?= $pembayaran['user_name'] ?></td>
                                                <td><?= $pembayaran['nama_paket'] ?></td>
                                                <td><?= $pembayaran['nama_metode'] ?></td>
                                                <td><a href="<?= BASE_URL . '../uploads/pembayaran/' . $pembayaran['bukti_pembayaran'] ?>" target="_blank" class="btn btn-sm btn-success ">Lihat</a></td>
                                                <td style="text-align:center !important;"><?= $pembayaran['tanggal_waktu'] ?></td>
                                                <td><?= ucfirst($pembayaran['status']) ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btnEdit btn btn-sm btn-warning" data-id="<?= $pembayaran['id_pembayaran'] ?>" aria-label="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button class="btnHapus btn btn-sm btn-danger" data-id="<?= $pembayaran['id_pembayaran'] ?>" aria-label="Hapus">
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
                <h5 class="modal-title" id="formModalLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASE_URL . 'simpan-pembayaran' ?>" method="post" id="formData" class="row g-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="invoice">Invoice</label>
                        <input type="text" name="invoice" id="invoice" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_user">Member</label>
                        <input type="hidden" name="id_user" id="id_user" class="form-control">
                        <input type="text" name="member" id="member" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_paket">Paket</label>
                        <input type="hidden" name="id_paket" id="id_paket" class="form-control">
                        <input type="text" name="nama_paket" id="nama_paket" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_waktu">Tanggal dan Waktu</label>
                        <input type="text" name="tanggal_waktu" id="tanggal_waktu" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_metode_pembayaran">Metode Pembayaran</label>
                        <input type="hidden" name="id_metode_pembayaran" id="id_metode_pembayaran" class="form-control">
                        <input type="text" name="metode_pembayaran" id="metode_pembayaran" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value=""></option>
                            <option value="pending">Pending</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan</label>
                        <input type="text" name="alasan" id="alasan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kode_wifi">Kode Wifi</label>
                        <input type="text" name="kode_wifi" id="kode_wifi" class="form-control">
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