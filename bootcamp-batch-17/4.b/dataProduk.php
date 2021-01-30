<?php 
require 'config.php';

$result = mysqli_query($conn, "SELECT * FROM produk_tb");
$dtaImportir = mysqli_query($conn, "SELECT * FROM importir_tb");

if (isset($_POST['addDataProduk'])) {
	$importir_id = $_POST["importir_id"];
	$name = $_POST["name"];
	$tmpname = $_FILES['photo']['tmp_name'];
	$photo = "produk-".date('mdy').date('His').".jpg";
	$qty = $_POST["qty"];
	$price = $_POST["price"];

	$query = "INSERT INTO produk_tb VALUES ('', '$importir_id', '$name', '$photo', '$qty', '$price')";

	mysqli_query($conn, $query);

	if (mysqli_affected_rows($conn) > 0){
		move_uploaded_file($tmpname,'image/upload/'.$photo);
		echo "<script>
		alert('Data Produk Berhasil ditambahkan!');
		document.location.href = 'index.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal ditambahkan!');
		</script>";
		echo mysqli_error($conn);
	}
}

if (isset($_POST['addDataImportir'])) {
	$name = $_POST["name"];
	$address = $_POST["address"];
	$phone = $_POST["phone"];

	$query = "INSERT INTO importir_tb VALUES ('', '$name', '$address', '$phone')";

	mysqli_query($conn, $query);

	if (mysqli_affected_rows($conn) > 0){
		echo "<script>
		alert('Data Importir Berhasil ditambahkan!');
		document.location.href = 'index.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal ditambahkan!');
		</script>";
		echo mysqli_error($conn);
	}
}

if (isset($_POST["editDataProduk"])) {
	$id = $_POST["id"];
	$importir_id = $_POST["importir_id"];
	$name = $_POST["name"];
	if ($_FILES['photo']['tmp_name'] != null) {
		$tmpname = $_FILES['photo']['tmp_name'];
		$photo = "produk-".date('mdy').date('His').".jpg";
		$image = "image/upload/".$_POST["foto_old"];
		if (file_exists($image)) unlink($image);
		move_uploaded_file($tmpname,'image/upload/'.$photo);
	} else {
		$photo = $_POST["foto_old"];
	}
	$qty = $_POST["qty"];
	$price = $_POST["price"];

	$query= "UPDATE produk_tb SET importir_id = '$importir_id', name = '$name', photo = '$photo', qty = '$qty', price = '$price' WHERE id = $id";

	mysqli_query($conn, $query);

	if (mysqli_affected_rows($conn)>0){
		echo "<script>
		alert('Data Produk Berhasil Diedit!');
		document.location.href='dataProduk.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal diedit!');
		</script>";
		echo mysqli_error($conn);
	}
}

if (isset($_GET['del'])) {
	$id = $_GET['id'];
	
	$getPhoto = mysqli_query($conn, "SELECT * FROM produk_tb WHERE id = '$id'");
	$photo = mysqli_fetch_assoc($getPhoto);
	$image = "image/upload/".$photo['photo'];
	if (file_exists($image)) unlink($image);
	
	mysqli_query($conn, "DELETE FROM produk_tb WHERE id='$id'");

	if (mysqli_affected_rows($conn)>0){
		echo "<script>
		alert('Data Pasien Berhasil Hapus!');
		document.location.href='dataProduk.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal dihapus!');
		</script>";
		echo mysqli_error($conn);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Agatu.ID Online Shopp</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/icons.css" rel="stylesheet" type="text/css">
	<link href="css/metismenu.min.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a href="index.php" class="navbar-brand"><img src="image/logo.png" alt="logo" height="50" width="120"></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item">
								<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item dropdown active">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Produk
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="dataProduk.php">Data Produk</a>
									<a class="dropdown-item" href="#" data-toggle="modal" data-target=".add-produk">Tambah Produk</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Importir
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="dataImportir.php">Data Importir</a>
									<a class="dropdown-item" href="#" data-toggle="modal" data-target=".add-importir">Tambah Importir</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>

				<div class="card-box">
					<h2 class="text-center">Data Produk</h2>
					<hr>

					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Nama Produk</th>
								<th>Importir</th>
								<th>Stok</th>
								<th>Harga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($result as $dta) { ?>
								<tr>
									<th scope="row"><?= $dta['name'] ?></th>
									<?php
									$importir_id = $dta['importir_id'];
									$getImportir = mysqli_query($conn, "SELECT * FROM importir_tb WHERE id = '$importir_id'");
									$importir = mysqli_fetch_assoc($getImportir);
									?>
									<td><?= $importir['name'] ?></td>
									<td><?= $dta['qty'] ?></td>
									<td>Rp. <?= $dta['price'] ?></td>
									<td style="max-width: 150px; min-width: 150px;" class="text-center">
										<button type="button" class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#myModal<?= $dta['id'] ?>">Detail</button>
										<button type="button" class="btn btn-success btn-sm m-0" data-toggle="modal" data-target=".modal-edit<?= $dta['id'] ?>">Edit</button>
										<button type="button" class="btn btn-danger btn-sm m-0" data-toggle="modal" data-target=".modal-delete<?= $dta['id'] ?>">Hapus</button>
									</td>
								</tr>

								<!-- Modal Detail -->
								<div id="myModal<?= $dta['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h5 class="modal-title" id="myModalLabel">Detail Produk</h5>
											</div>
											<div class="modal-body">
												<img src="image/upload/<?= $dta['photo'] ?>" style="min-height: 320px; max-height: 320px; width: 100%;" class="card-img-top" alt="foto sepeda">
												<dl class="row mb-0">
													<dt class="col-sm-5">Nama Produk</dt>
													<dd class="col-sm-7"><?= $dta['name'] ?></dd>

													<dt class="col-sm-5">Nama Importir</dt>
													<dd class="col-sm-7"><?= $importir['name'] ?></dd>

													<dt class="col-sm-5">Stok</dt>
													<dd class="col-sm-7"><?= $dta['qty'] ?></dd>

													<dt class="col-sm-5">Harga</dt>
													<dd class="col-sm-7"><?= $dta['price'] ?></dd>
												</dl>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>

								<!-- modal edit -->
								<div class="modal modal-edit<?= $dta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myLargeModalLabel">Edit Produk</h4>
											</div>
											<div class="modal-body px-5">
												<form id="form-edit" action="#" method="POST" enctype="multipart/form-data">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Nama Produk</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" required="" placeholder="Nama Produk" name="name" value="<?= $dta['name'] ?>">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Nama Importir</label>
														<div class="col-sm-9">
															<select name="importir_id" class="form-control">
																<?php foreach ($dtaImportir as $val) { ?>
																	<option <?php if ($val['id'] == $dta['importir_id']) echo "selected" ?> value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Stok</label>
														<div class="col-sm-9">
															<input type="number" class="form-control" required="" placeholder="Stok" name="qty" value="<?= $dta['qty'] ?>">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Harga</label>
														<div class="col-sm-9">
															<input type="number" class="form-control" required="" placeholder="Harga" name="price" value="<?= $dta['price'] ?>">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Foto</label>
														<div class="col-sm-9">
															<input type="file" class="form-control" placeholder="Foto" name="photo" text>
														</div>
													</div>
													<div class="row" style="margin-top: -10px;">
														<div class="col-sm-3">
															<input type="hidden" name="id" value="<?= $dta['id'] ?>">
															<input type="hidden" name="foto_old" value="<?= $dta['photo'] ?>">
														</div>
														<div class="col-sm-9">
															<p><?= $dta['photo'] ?> | <span class="text-info">Note: silahkan pilih foto lain untuk mengupdate foto</span></p>
														</div>
													</div>
													<div class="form-group">
														<div>
															<button type="submit" name="editDataProduk" class="btn btn-primary waves-effect waves-light">Submit</button>
															<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
														</div>
													</div>
												</form>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>

								<!-- modal hapus -->
								<div class="modal modal-delete<?= $dta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h5 class="modal-title" id="myModalLabel">Hapus Data?</h5>
											</div>
											<div class="modal-body">
												<p>Yakin ingin menghapus data ini?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Batal</button>
												<a href="dataProduk.php?del=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger waves-effect waves-light">Hapus</a>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- modal add produk -->
	<div class="modal add-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Produk</h4>
				</div>
				<div class="modal-body px-5">
					<form id="form-edit" action="#" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Produk</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="Nama Produk" name="name">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Importir</label>
							<div class="col-sm-9">
								<select name="importir_id" class="form-control">
									<?php foreach ($dtaImportir as $val) { ?>
										<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Stok</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" required="" placeholder="Stok" name="qty">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Harga</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" required="" placeholder="Harga" name="price">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Foto</label>
							<div class="col-sm-9">
								<input type="file" class="form-control" required="" placeholder="Foto" name="photo">
							</div>
						</div>
						<div class="form-group">
							<div>
								<button type="submit" name="addDataProduk" class="btn btn-primary waves-effect waves-light">Submit</button>
								<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<!-- modal add importir -->
	<div class="modal add-importir" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Importir</h4>
				</div>
				<div class="modal-body px-5">
					<form id="form-edit" action="#" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Importir</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="Nama Importir" name="name">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Alamat</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="Alamat" name="address">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Telepon</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" required="" placeholder="Telepon" name="phone">
							</div>
						</div>
						<div class="form-group">
							<div>
								<button type="submit" name="addDataImportir" class="btn btn-primary waves-effect waves-light">Submit</button>
								<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
