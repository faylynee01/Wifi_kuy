<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pengaturan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Pengaturan
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
                        <form action="<?= BASE_URL . 'simpan-pengaturan' ?>" method="post">
                            <div class="form-group row g-1 col-lg-6 col-sm-12 mb-3">
                                <label for="nama_web">Nama Website</label>
                                <input type="text" name="nama_web" id="nama_web" value="<?= $data['pengaturan']['nama_web'] ?? '' ?>" placeholder="" class="form-control">
                            </div>
                            <div class="form-group row g-1 col-lg-6 col-sm-12 mb-3">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" value="<?= $data['pengaturan']['no_telp'] ?? '' ?>" placeholder="" class="form-control">
                            </div>
                            <div class="form-group row g-1 col-lg-6 col-sm-12 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?= $data['pengaturan']['email'] ?? '' ?>" placeholder="" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end::Row--> <!--begin::Row-->

    </div> <!--end::Container-->
</div> <!--end::App Content-->