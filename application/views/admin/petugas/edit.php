<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/navbar') ?>
<?php $this->load->view('templates/sidebar') ?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Halaman Edit File</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Halaman Edit File</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div class="card-title">
								Form update
							</div>
						</div>
						<form action="<?= base_url('admin/updatePetugas/') ?>" method="post">
							<div class="card-body">
								<?php if (isset($petugas)){ ?>
									<div class="form-group">
										<label for="nama_lengkap">Nama Lengkap</label>
										<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= $petugas['nama_lengkap'] ?? '' ?>" required>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat</label>
										<input type="text" name="alamat" id="alamat" class="form-control" required>
									</div>
									<div class="form-group">
										<label for="jenis_kelamin">Jenis Kelamin</label>
										<select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
											<option selected disabled>Pilih Jenis Kelamin</option>
											<option value="Laki-Laki">Laki-Laki</option>
											<option value="Perempuan">Perempuan</option>
										</select>
									</div>
									<div class="form-group">
										<label for="tanggal_lahir">Tanggal Lahir</label>
										<input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
									</div>
								<?php } else { ?>
									Data Belum Diperbaharui
								<?php } ?>
							</div>
							<div class="modal-footer">
								<a href="<?= base_url('admin/petugas') ?>" class="btn btn-secondary">Kembali</a>
								<button class="btn btn-primary" type="submit">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?php $this->load->view('templates/footer') ?>
