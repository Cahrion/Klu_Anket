<!doctype html>
<html lang="en">

<head>
	<title>Admin Güncelle</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="<?php echo base_url("css/minRequire.css");?>">
	<link rel="stylesheet" href="<?php echo base_url("css/admin.css");?>">
</head>

<body>
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-2"></div>
		<div class="col-8 pt-3">			
			<div class="adminButton"><a href="<?php echo base_url("AdminController"); ?>"><i class="fa-solid fa-list"></i> Yöneticiler Listesi</a></div>
			<form action="<?php echo base_url("AdminController/adminPanelGuncelle/" . $yoneticiBilgileri->id);?>" method="post">
				<div class="mb-3">
					<label for="emailAdresi" class="form-label">Email Adresi</label>
					<input type="email" class="form-control" name="emailAdresi" id="emailAdresi" aria-describedby="helpId" placeholder="Email Adresini giriniz" value="<?php echo $yoneticiBilgileri->emailAdresi?>">
				</div>
				<div class="mb-3">
					<label for="yonetimFaktoru" class="form-label">Yonetici Rolu</label>
					<select class="form-control" name="yonetimFaktoru" id="yonetimFaktoru"> 
						<?php
							// Ternary yapısıyla selected kavramını kullandım
						?>
						<option value="0" <?php echo $yoneticiBilgileri->yonetimFaktoru?"selected":"";?>>Yönetici</option> 
						<option value="1" <?php echo $yoneticiBilgileri->yonetimFaktoru?"selected":"";?>>Üst Düzey Yönetici</option>
					</select>
				</div>
				<input type="submit" class="btn btn-primary" value="Gönder">
			</form>
		</div>
		<div class="col-2"></div>
	</div>
	<?php
	include_once 'includes/footer.php';
	?>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>