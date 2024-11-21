<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
    <li class="nav-item"> <a href="<?= BASE_URL . '' ?>" class="nav-link <?= $data['title'] == 'Dashboard' ? 'active' : '' ?>"> <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
        </a> </li>
    <li class="nav-item"> <a href="<?= BASE_URL . 'kelola-paket' ?>" class="nav-link <?= $data['title'] == 'Kelola Paket' ? 'active' : '' ?>"> <i class="nav-icon bi bi-router"></i>
            <p>Kelola Paket</p>
        </a> </li>
    <li class="nav-item"> <a href="<?= BASE_URL . 'kelola-pengguna' ?>" class="nav-link <?= $data['title'] == 'Kelola Pengguna' ? 'active' : '' ?>"> <i class="nav-icon bi bi-people"></i>
            <p>Kelola Pengguna</p>
        </a> </li>
    <li class="nav-item"> <a href="<?= BASE_URL . 'kelola-pembayaran' ?>" class="nav-link <?= $data['title'] == 'Kelola Pembayaran' ? 'active' : '' ?>"> <i class="nav-icon bi bi-cash"></i>
            <p>Kelola Pembayaran</p>
        </a> </li>
    <li class="nav-item"> <a href="<?= BASE_URL . 'metode-pembayaran' ?>" class="nav-link <?= $data['title'] == 'Metode Pembayaran' ? 'active' : '' ?>"> <i class="nav-icon bi bi-wallet"></i>
            <p>Metode Pembayaran</p>
        </a> </li>
    <li class="nav-item"> <a href="<?= BASE_URL . 'pengaturan' ?>" class="nav-link <?= $data['title'] == 'Pengaturan' ? 'active' : '' ?>"> <i class="nav-icon bi bi-gear"></i>
            <p>Pengaturan</p>
        </a> </li>

</ul> <!--end::Sidebar Menu-->