<?php 
require 'config.php';

// Get Data
if (isset($_POST['search'])) {
	$keyword = $_POST['keyword'];
	$result = mysqli_query($conn, "SELECT * FROM tb_school WHERE name_school LIKE '%$keyword%' ORDER BY id DESC");
	$title = "Hasil Pencarian";
} else {
	$result = mysqli_query($conn, "SELECT * FROM tb_school ORDER BY id DESC");
	$title = "Data Sekolah";
}

// Add Data
if (isset($_POST['addData'])) {
	$user_id = $_POST["user_id"];
	$npsn = $_POST["npsn"];
	$name_school = $_POST["name_school"];
	$address = $_POST["address"];
	$tmpname = $_FILES['logo_school']['tmp_name'];
	$logo_school = "logo-school-".date('mdy').date('His').".jpg";
	$school_level = $_POST["school_level"];
	$status_school = $_POST["status_school"];

	$query = "INSERT INTO tb_school VALUES (NULL, '$user_id', '$npsn', '$name_school', '$address', '$logo_school', '$school_level', '$status_school')";

	mysqli_query($conn, $query);

	if (mysqli_affected_rows($conn) > 0){
		move_uploaded_file($tmpname,'image/logo/'.$logo_school);
		echo "<script>
		alert('Data Sekolah berhasil ditambahkan!');
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

// Edit Data
if (isset($_POST["editData"])) {
	$id = $_POST["id"];
	$user_id = $_POST["user_id"];
	$npsn = $_POST["npsn"];
	$name_school = $_POST["name_school"];
	$address = $_POST["address"];
	if ($_FILES['logo_school']['tmp_name'] != null) {
		$tmpname = $_FILES['logo_school']['tmp_name'];
		$logo_school = "logo-school-".date('mdy').date('His').".jpg";
		$image = "image/logo/".$_POST["logo_old"];
		if (file_exists($image)) unlink($image);
		move_uploaded_file($tmpname,'image/logo/'.$logo_school);
	} else {
		$logo_school = $_POST["logo_old"];
	}
	$school_level = $_POST["school_level"];
	$status_school = $_POST["status_school"];

	$query= "UPDATE tb_school SET user_id='$user_id', npsn='$npsn', name_school='$name_school', address='$address', logo_school='$logo_school', school_level='$school_level', status_school='$status_school' WHERE id = $id";

	if (mysqli_query($conn, $query)){
		echo "<script>
		alert('Data School Berhasil Diedit!');
		document.location.href='index.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal diedit!');
		</script>";
		echo mysqli_error($conn);
	}
}

// Delete Data
if (isset($_GET['delete'])) {
	$id = $_GET['id'];
	
	$get_logo = mysqli_query($conn, "SELECT * FROM tb_school WHERE id = '$id'");
	$logo = mysqli_fetch_assoc($get_logo);
	$image = "image/upload/".$logo['logo_school'];
	if (file_exists($image)) unlink($image);
	
	mysqli_query($conn, "DELETE FROM tb_school WHERE id='$id'");

	if (mysqli_affected_rows($conn)>0){
		echo "<script>
		alert('Data School Berhasil Hapus!');
		document.location.href='index.php';
		</script>";
	}
	else {
		echo "<script>
		alert('Gagal dihapus!');
		</script>";
		echo mysqli_error($conn);
	}
}

// Profil Area 
if (isset($_SESSION['session_login'])) {
	$ths_user_id = $_SESSION['user_id'];
	$get_users = mysqli_query($conn, "SELECT * FROM users WHERE id='$ths_user_id'");
	$acn = mysqli_fetch_assoc($get_users);

	if (isset($_POST["UpdtProfile"])) {
		$id = $_POST["id"];
		$name = $_POST["name"];
		$email = $_POST["email"];

		if (isset($_POST['password'])) {
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$query= "UPDATE users SET name='$name', email='$email', password='$password' WHERE id = $id";
		} else {
			$query= "UPDATE users SET name='$name', email='$email' WHERE id = $id";
		}

		if (mysqli_query($conn, $query)){
			echo "<script>
			alert('Profile Berhasil Diupdate!');
			document.location.href='index.php';
			</script>";
		}
		else {
			echo "<script>
			alert('Gagal diedit!');
			</script>";
			echo mysqli_error($conn);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>School Data</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/icons.css" rel="stylesheet" type="text/css">
	<link href="css/metismenu.min.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow px-5">
					<a href="index.php">
						<h2 class="text-white">School <span class="text-warning">Data</span></h2>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse row justify-content-center" id="navbarSupportedContent">
						<ul class="navbar-nav col-lg-8 justify-content-end">
							<li class="">
								<form class="form-inline mt-2 mb-2 ml-2" method="POST">
									<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
									<button class="btn btn-outline-warning my-2 my-sm-0" type="submit" name="search">Search</button>
								</form>
							</li>
						</ul>
						<div class="col-lg-4 text-right mt-2 mb-2 pr-0">
							<?php if (isset($_SESSION['session_login'])) { ?>
								<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target=".add-data">Add School</button>
								<button id="btnGroupDrop1" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Account
								</button>
								<div class="dropdown-menu" style="margin-left: 70px;" aria-labelledby="btnGroupDrop1">
									<a class="dropdown-item" href="#" data-toggle="modal" data-target=".modal-profile">Profile</a>
									<a class="dropdown-item" href="config.php?logout=true">Logout</a>
								</div>
							<?php } else { ?>
								<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target=".to-login">Add School</button>
								<a href="login.php" class="btn btn-success btn-sm text-white ">Login</a>
							<?php } ?>
						</div>
					</div>
				</nav>

				<div class="card-box bg-dark shadow">
					<h2 class="text-center text-white"><?= $title ?></h2>
					<hr>
					<div class="row">
						<?php foreach ($result as $dta) { ?>
							<div class="col-md-3 mt-3">
								<div class="card bg-secondary text-white" style="width: auto;">
									<img src="image/logo/<?= $dta['logo_school'] ?>" style="min-height: 200px; max-height: 200px;" class="card-img-top" alt="foto sepeda">
									<div class="card-body">
										<b><?= substr($dta['name_school'], 0, 15) ?>...</b>
										<p style="font-size: 12px;"><?= $dta['school_level'] ?> | <?= $dta['status_school'] ?></p>
										<?php if (isset($_SESSION['session_login'])) { ?>
											<div class="row">
												<a href="#" class="col-sm-4 btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#myModal<?= $dta['id'] ?>">Detail</a>			
												<a href="#" class="col-sm-4 btn btn-success btn-sm text-white" data-toggle="modal" data-target=".add-edit<?= $dta['id'] ?>">Edit</a>	
												<a href="#" class="col-sm-4 btn btn-danger btn-sm text-white" data-toggle="modal" data-target=".modal-delete<?= $dta['id'] ?>">Hapus</a>	
											</div>
										<?php } else { ?>
											<a href="#" class="btn btn-secondary btn-sm btn-block text-warning" data-toggle="modal" data-target="#myModal<?= $dta['id'] ?>">View Detail</a>
										<?php } ?>
									</div>
								</div>
							</div>

							<!-- Modal Detail -->
							<div id="myModal<?= $dta['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h5 class="modal-title" id="myModalLabel">Detail School</h5>
										</div>
										<div class="modal-body">
											<img src="image/logo/<?= $dta['logo_school'] ?>" style="min-height: 320px; max-height: 320px; width: 100%;" class="card-img-top" alt="foto sepeda">
											<hr>
											<dl class="row mb-0">
												<dt class="col-sm-5">NPSN:</dt>
												<dd class="col-sm-7"><?= $dta['npsn'] ?></dd>

												<dt class="col-sm-5">Name School:</dt>
												<dd class="col-sm-7"><?= $dta['name_school'] ?></dd>

												<dt class="col-sm-5">Address:</dt>
												<dd class="col-sm-7"><?= $dta['address'] ?></dd>

												<dt class="col-sm-5">Shool Level:</dt>
												<dd class="col-sm-7"><?= $dta['school_level'] ?></dd>

												<dt class="col-sm-5">Status:</dt>
												<dd class="col-sm-7"><?= $dta['status_school'] ?></dd>

												<?php 
												$user_id = $dta['user_id'];
												$users = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
												$usr = mysqli_fetch_assoc($users);
												?>

												<dt class="col-sm-5">Input By:</dt>
												<dd class="col-sm-7"><?= $usr['name'] ?> (<?= $usr['email'] ?>)</dd>
											</dl>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-warning waves-effect" data-dismiss="modal">Tutup</button>
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div>

							<?php if (isset($_SESSION['session_login'])) { ?>
								<!-- modal edit -->
								<div class="modal add-edit<?= $dta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myLargeModalLabel">Add School Data</h4>
											</div>
											<div class="modal-body px-5">
												<form action="#" method="POST" enctype="multipart/form-data">
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">NPSN</label>
														<div class="col-sm-8">
															<input type="number" class="form-control" required="" placeholder="NPSN" name="npsn" value="<?= $dta['npsn'] ?>">
														</div>
													</div>							
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">Name School</label>
														<div class="col-sm-8">
															<input type="hidden" name="user_id" value="<?= $dta['user_id'] ?>">
															<input type="text" class="form-control" required="" placeholder="Name School" name="name_school" value="<?= $dta['name_school'] ?>">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">Address</label>
														<div class="col-sm-8">
															<textarea class="form-control" rows="3" required="" placeholder="Address" name="address"><?= $dta['address'] ?></textarea>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">School Level</label>
														<div class="col-sm-8">
															<select name="school_level" class="form-control" required="">
																<option value="">--School Level--</option>
																<?php 
																$school_level = ['SD', 'SMP', 'SMA'];
																foreach ($school_level as $scl) {
																	if ($scl == 'SD') $cpt = 'SEKOLAH DASAR (SD)';
																	else if ($scl == 'SMP') $cpt = 'SEKOLAH MENENGAH PERTAMA (SMP)';
																	else if ($scl == 'SMA') $cpt = 'SEKOLAH MENENGAH ATAS (SMA)';

																	if ($scl == $dta['school_level']) $opt = 'selected';
																	else $opt = ''; ?>
																	<option value="<?= $scl ?>" <?= $opt ?>><?= $cpt ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">Status School</label>
														<div class="col-sm-8">
															<select name="status_school" class="form-control" required="">
																<option value="">--Status School--</option>
																<?php 
																$status_school = ['NEGERI', 'SWASTA'];
																foreach ($status_school as $stss) {
																	if ($stss == $dta['status_school']) $opt = 'selected';
																	else $opt = ''; ?>
																	<option value="<?= $stss ?>" <?= $opt ?>><?= $stss ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">Logo School</label>
														<div class="col-sm-8">
															<input type="file" class="form-control" placeholder="Logo School" name="logo_school">
														</div>
													</div>
													<div class="row" style="margin-top: -10px;">
														<div class="col-sm-4">
															<input type="hidden" name="id" value="<?= $dta['id'] ?>">
															<input type="hidden" name="logo_old" value="<?= $dta['logo_school'] ?>">
														</div>
														<div class="col-sm-8">
															<p><?= $dta['logo_school'] ?> <br> <span class="text-info">Note: pilih foto lain untuk mengupdate foto</span></p>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-4 col-form-label">&nbsp;</label>
														<div class="col-sm-8">
															<button type="submit" name="editData" class="btn btn-warning waves-effect waves-light">Update</button>
															<button type="" class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Batal</button>
														</div>
													</div>
												</form>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>

								<!-- modal hapus -->
								<div class="modal modal-delete<?= $dta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h5 class="modal-title" id="myModalLabel">Hapus Data?</h5>
											</div>
											<div class="modal-body">
												<p>Yakin ingin menghapus data ini?</p>
											</div>
											<div class="modal-footer">
												<a href="index.php?delete=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger waves-effect waves-light">Hapus</a>
												<button type="button" class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Batal</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>
							<?php } ?>
						<?php } ?>
					</div>
					<?php if (empty($dta)) {?>
						<div class="text-center">
							<h4><i>Hasil tidak di temukan <a href="index.php">Kembali...</a></i></h4>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php if (isset($_SESSION['session_login'])) { ?>
		<!-- modal add -->
		<div class="modal add-data" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myLargeModalLabel">Add School Data</h4>
					</div>
					<div class="modal-body px-5">
						<form action="#" method="POST" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NPSN</label>
								<div class="col-sm-8">
									<input type="number" class="form-control" required="" placeholder="NPSN" name="npsn">
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Name School</label>
								<div class="col-sm-8">
									<input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
									<input type="text" class="form-control" required="" placeholder="Name School" name="name_school">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Address</label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="3" required="" placeholder="Address" name="address"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">School Level</label>
								<div class="col-sm-8">
									<select name="school_level" class="form-control" required="">
										<option value="">--School Level--</option>
										<option value="SD">SEKOLAH DASAR (SD)</option>
										<option value="SMP">SEKOLAH MENENGAH PERTAMA (SMP)</option>
										<option value="SMA">SEKOLAH MENENGAH ATAS (SMA)</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status School</label>
								<div class="col-sm-8">
									<select name="status_school" class="form-control" required="">
										<option value="">--Status School--</option>
										<option value="NEGERI">NEGERI</option>
										<option value="SWASTA">SWASTA</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Logo School</label>
								<div class="col-sm-8">
									<input type="file" class="form-control" required="" placeholder="Logo School" name="logo_school">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">&nbsp;</label>
								<div class="col-sm-8">
									<button type="submit" name="addData" class="btn btn-warning waves-effect waves-light">Submit</button>
									<button type="" class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Batal</button>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>

		<!-- modal edit akun-->
		<div class="modal modal-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myLargeModalLabel">Profile</h4>
					</div>
					<div class="modal-body px-5">
						<form action="#" method="POST" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Full Name</label>
								<div class="col-sm-8">
									<input type="hidden" name="id" value="<?= $acn['id'] ?>">
									<input type="text" class="form-control" required="" placeholder="Full Name" name="name" value="<?= $acn['name'] ?>">
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Email</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" required="" placeholder="Email" name="email" value="<?= $acn['email'] ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" placeholder="Password" name="password" value="">
								</div>
							</div>
							<div class="row" style="margin-top: -10px;">
								<div class="col-sm-4">
								</div>
								<div class="col-sm-8">
									<span class="text-info">Note: masukkan password baru untuk mengganti password</span></p>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">&nbsp;</label>
								<div class="col-sm-8">
									<button type="submit" name="UpdtProfile" class="btn btn-warning waves-effect waves-light">Update</button>
									<button type="" class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Batal</button>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	<?php } else { ?>
		<!-- modal to login -->
		<div class="modal to-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h5 class="modal-title" id="myModalLabel">Belum Login</h5>
					</div>
					<div class="modal-body">
						<p>Anda harus login terlebih dahulu untuk mengimput data!</p>
					</div>
					<div class="modal-footer">
						<a href="login.php" role="button" class="btn btn-warning waves-effect waves-light">Login</a>
						<button type="button" class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Batal</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	<?php } ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>