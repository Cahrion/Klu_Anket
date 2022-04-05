<!doctype html>
<html lang="en">

<head>
	<title>Yonetim</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href="<?php echo base_url(); ?>">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="<?php echo base_url("css/minRequire.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("css/Central.css"); ?>">
	<script src="<?php echo base_url("js/Central.js"); ?>"></script>
</head>

<body>
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-2"></div>
		<div class="col-8">
			<!-- Anket bilgilerini seçiçek ve dolduracak		 -->
			<div class="anketHeadCoverager mt-4">
				<div class="baslik">
					<input type="text" placeholder="ANKET BAŞLIĞI" class="anketHeadCoveragerHeader">
				</div>
				<div class="baslikMetni">
					<textarea class="text-muted anketHeadCoveragerHeadText" cols="30" rows="10" placeholder="Anket üst bilgisini giriniz"></textarea>
				</div>
				<div class="aciklamaMetni">
					<textarea class="text-muted anketHeadCoveragerExplanationText" cols="30" rows="10" placeholder="Anket hakkında açıklama yapınız."></textarea>
				</div>
				<div class="row formAlanKapsayici">
					<div class="col-8 formKitle">
						<select class="form-control mb-3" id="formKitleSelected">
							<option value="">Lütfen bir kitle seçiniz</option>
							<option value="ogrenci">Ögrenci</option>
							<option value="akademik">Akademik</option>
							<option value="idari">İdari</option>
						</select>
					</div>
					<div class="col-4 formCheck">
						<div class="form-check form-switch formAlan" style="float: right;">
							<input class="form-check-input" type="checkbox" id="anketGirisZorunluluk" onclick="anketGirisZorunluluk(this)">
							<label class="form-check-label" for="anketGirisZorunluluk" style="color:red;font-weight:bold">Uyelik Şart</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8 anketPlatform">
					<div class="GroupCoverager mt-4">
						<div class="anketGroupHeadCoverager">
							<div class="renkAlani" onclick='renkAlani(this)'></div>
							<div class="baslik">
								<input type="text" placeholder="Grup Başlığı" class="anketGroupHeadCoveragerHeader">
							</div>
							<div class="baslikMetni">
								<textarea class="text-muted anketGroupHeadCoveragerHeadText" cols="30" rows="10" placeholder="Detay bilgisini giriniz"></textarea>
							</div>
							<div class="anketSecenekler row">
								<div class="col-10 anketSeceneklerIcAlan">
									<input type="text" placeholder="Seçenekler" class="anketGroupOptions">
								</div>
								<!-- Kullanıcı şık ekleme alanı -->
								<div class="col-2 text-center">
									<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
								</div>
							</div>
						</div>
						<div class="anketCoverager">
							<div class="anketSoru">
								<input type="text" placeholder="Soru" class="anketSoruVal">
							</div>
							<div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
								<input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' checked>
								<label class="form-check-label" for="" style="color:red;font-weight:bold">Zorunlu</label>
							</div>
							<!-- Kullanıcı soru ekleme alanı -->
							<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
							<span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
						</div>
					</div>
				</div>
				<div class="col-0 col-sm-2"></div>
			</div>

			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8" style="text-align:right">
					<button id="veriGonder" type="button" class="btn btn-primary mt-4"><i class="fa-solid fa-plus"></i> Anketi Oluştur</button>
				</div>
				<div class="col-0 col-sm-2"></div>
			</div>
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