<!doctype html>
<html lang="en">

<head>
	<title>Admin Panel</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/";?>css/minRequire.css">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/";?>css/admin.css">
</head>

<body>
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-2"></div>
		<div class="col-8 pt-3">
			<div class="adminButton"><a href="<?php echo $SiteLinki . "public/adminController/adminEkle"?>">+ Yeni Yönetici Ekle</a></div>
            <?php 
					foreach($YoneticilerKayitlari as $YoneticilerSatirlari){
			?>	
				<div class="row border border-secondary mt-2">
					<div class="col-4 p-4"><b>Gmail</b> = <?php echo $YoneticilerSatirlari->emailAdresi; ?></div>
					<?php
						// Ternary yapısıyla yöneticinin durumunu isimlendiriyorum.
						$yonetimDurumu = $YoneticilerSatirlari->yonetimFaktoru=1?"Üst Düzey Yönetici":"Yönetici";
					?>
					<div class="col-4 p-4"><b>Yonetici Durumu</b> = <?php echo $yonetimDurumu; ?> </div>
					<div class="col-4 p-4" style="text-align:right">
						<a href="<?php 	echo $SiteLinki . "public/adminController/adminGuncelle/" . $YoneticilerSatirlari->id; ?>"><img src="<?php echo $SiteLinki . "public/img/Guncelleme20x20.png"?>" ></a>
						<a href="<?php  echo $SiteLinki . "public/adminController/adminGuncelle/" . $YoneticilerSatirlari->id; ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a>
						<a href="<?php  echo $SiteLinki . "public/adminController/adminPanelSil/" . $YoneticilerSatirlari->id; ?>"><img src="<?php echo $SiteLinki . "public/img/Sil20x20.png"?>"></a>
						<a href="<?php  echo $SiteLinki . "public/adminController/adminPanelSil/" . $YoneticilerSatirlari->id; ?>" style="color: #FF0000; text-decoration: none;">Sil</a>
					</div>
				</div>
			<?php
				}
			?>
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