<!doctype html>
<html lang="en">
<?php
use App\Models\IslemModel;
?>
<head>
	<title>Admin Panel</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="<?php echo base_url("css/minRequire.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("css/admin.css"); ?>">
</head>

<body>
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-1 col-md-2"></div>
		<div class="col-10 col-md-8 pt-3">
			<div class="adminButton"><a href="<?php echo base_url("ownerController"); ?>"><i class="fa-solid fa-circle-plus"></i> Yeni Anket Ekle</a></div>
			<div class="row">
				<?php
				foreach ($anketKayitlari as $anketKaydi) { // Yoneticiler Kayitları bize arka plandan gelmişti onu kullandık.
				?>
					<div class="col-12 col-md-6 col-xl-4 p-3">
						<div class="card shadow-sm">
							<div class="card-header" style="height:120px;overflow-y:hidden">
								<?php echo $anketKaydi->baslik; ?>
							</div>
							<div class="card-body">
								<a class="btn col-12 mb-2" style="background-color:darkred;color:white" href="<?php echo base_url("ownerController/AnketAnaliz/" . $anketKaydi->id); ?>">
									Analiz <i class="fa-solid fa-magnifying-glass-chart"></i>
								</a>
								<a class="btn col-12 mb-2"  style="background-color:#212529;color:white" href="<?php echo base_url("ownerController/adminAnketLinkOlustur/" . $anketKaydi->id); ?>" role="button">
									<i class="fa-solid fa-link"></i>
									Link
								</a>
								<a class="btn col-12 mb-2 text-center" style="border:1px solid grey;background-color:white;color:grey" href="<?php echo base_url("ownerController/adminProfil/" . $anketKaydi->yoneticiID); ?>" >
									<i class="fa-solid fa-user"></i>
									<?php
										$Islem = new IslemModel();
										$gelenYonetici = $Islem->getControlMemberID($anketKaydi->yoneticiID);
										echo $gelenYonetici->emailAdresi;
									?>
								</a>
							</div>
							<div class="card-footer row m-0">
								<?php
								// Ternary yapısıyla anketin durumunu isimlendiriyorum.
								$onayDurumu     = $anketKaydi->onay ? "Onaylandı" : "Onaylanmadı";
								$onayRenk       = $anketKaydi->onay ? "success" : "danger";
								$title          = $anketKaydi->onay ? "Onay kaldır." : "Onayla";
								?>
								<div class="col-12 text-center pt-2">
									<a class="btn border border-<?php echo $onayRenk ?> col-12 text-<?php echo $onayRenk ?>" style="border-style: dashed!important;font-weight: bold;display:block" role="button" title="<?php echo $title ?>"  href="<?php echo base_url("ownerController/anketOnay/" . $anketKaydi->id); ?>">
										<?php echo $onayDurumu; ?>
									</a>
								</div>
								<div class="col-12 pt-2 d-flex justify-content-between">
									<a href="<?php echo base_url("ownerController/adminAnketGuncelle/" . $anketKaydi->id); ?>" style="color: #05056a; text-decoration: none;"><i class="fa-solid fa-marker"></i> Güncelle</a>
									<a href="<?php echo base_url("ownerController/ustAdminAnketSil/" . $anketKaydi->id); ?>" style="color: darkred; text-decoration: none;"><i class="fa-solid fa-ban"></i> Sil</a>
								</div>
							</div>

						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="col-1 col-md-2"></div>
	</div>
	<?php
	include_once 'includes/footer.php';
	?>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
