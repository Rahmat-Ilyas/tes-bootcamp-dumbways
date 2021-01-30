<?php 
require 'config.php';

if (isset($_POST['search'])) {
	$keyword = $_POST['keyword'];
	$result = mysqli_query($conn, "SELECT * FROM produk_tb WHERE name LIKE '%$keyword%' ORDER BY id DESC");
	$title = "Hasil Pencarian";
} else {
	$result = mysqli_query($conn, "SELECT * FROM produk_tb ORDER BY id DESC");
	$title = "Produk Terbaru";
}

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
							<li class="nav-item active">
								<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item dropdown">
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
						<form class="form-inline my-2 my-lg-0" method="POST">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
						</form>
					</div>
				</nav>

				<div class="card-box">
					<h2 class="text-center"><?= $title ?></h2>
					<hr>

					<div class="row">
						<?php foreach ($result as $dta) { ?>
							<div class="col-4 mt-3">
								<div class="card bg-light" style="width: 18rem;">
									<img src="image/upload/<?= $dta['photo'] ?>" style="min-height: 250px; max-height: 250px;" class="card-img-top" alt="foto sepeda">
									<div class="card-body">
										<h5 class="card-title"><?= $dta['name'] ?></h5>
										<?php
										$importir_id = $dta['importir_id'];
										$getImportir = mysqli_query($conn, "SELECT * FROM importir_tb WHERE id = '$importir_id'");
										$importir = mysqli_fetch_assoc($getImportir);
										?>
										<p class="card-text"><?= $importir['name'] ?></p>
										<p>
											<b class="text-danger" style="font-size: 18px;">Rp. <?= $dta['price'] ?></b>
											<span class="ml-5 pl-4"><b>Stok: <?= $dta['qty']?></b></span>
										</p>
										<a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal<?= $dta['id'] ?>">Lihat Detail</a>
									</div>
								</div>
							</div>

							<!-- Modal -->
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
						<?php } ?>
					</div>
					<?php if (empty($dta)) {?>
						<div class="text-center">
							<h4><i>Hasil tidak di temukan</i></h4>
						</div>
					<?php } ?>
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