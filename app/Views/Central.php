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

<body onscroll="scrollSelector(this)">
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-0 col-sm-1 col-xl-2"></div>
		<div class="col-12 col-sm-10 col-xl-8">
			<!-- Anket bilgilerini seçiçek ve dolduracak		 -->
			<div class="anketHeadCoverager mt-4">
				<div class="baslik">
					<input type="text" placeholder="ANKET BAŞLIĞI" class="anketHeadCoveragerHeader">
				</div>
				<div class="baslikMetni">
					<textarea class="text-muted anketHeadCoveragerHeadText" cols="30" rows="10" placeholder="Anket üst bilgisi"></textarea>
				</div>
				<div class="aciklamaMetni">
					<textarea class="text-muted anketHeadCoveragerExplanationText" cols="30" rows="10" placeholder="Anketin açıklaması"></textarea>
				</div>
				<div class="row formAlanKapsayici">
					<div class="col-8 formKitle">
						<select class="form-select mb-3" id="formKitleSelected">
							<option value="">Anket Kimler Tarafından Doldurulacak?</option>
							<option value="akademik">Akademik Personeller</option>
							<option value="idari">İdari Personeller</option>
							<option value="ogrenci">Öğrenciler</option>
							<option value="herkes">Herkes</option>
						</select>
					</div>
					<div class="col-4 formCheck">
						<div class="form-check form-switch formAlan" style="float: right;">
							<input class="form-check-input" type="checkbox" id="anketGirisZorunluluk" onclick="anketGirisZorunluluk(this)">
							<label class="form-check-label" for="anketGirisZorunluluk" style="color:black;font-weight:bold;">Eposta ile Girişi Zorunlu Tut
								<span style="font-size:10px;display:block" class="text-muted">(Sadece klu.edu.tr uzantılı e-postaya sahip olanlar girebilir.)</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="text-end ustVeriAlan" style="display: none">
				<button class="veriGonder btn btn-primary mt-4" type="button"><i class="fa-solid fa-plus"></i> Anketi Oluştur</button>
			</div>
			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8 anketPlatform">
					<div class="GroupCoverager mt-4" name="1">
						<div class="anketGroupHeadCoverager">
							<div class="renkAlani" onclick='renkAlani(this)'></div>
							<div class="baslik">
								<input type="text" placeholder="Grup başlığı" class="anketGroupHeadCoveragerHeader">
							</div>
							<div class="baslikMetni">
								<textarea class="text-muted anketGroupHeadCoveragerHeadText" cols="30" rows="10" placeholder="Grup detay bilgisi"></textarea>
							</div>
							<div class="anketSecenekler row" name="1secenek1">
								<div class="col-8 col-sm-6 col-md-7 col-lg-9 col-xl-10 anketSeceneklerIcAlan">
									<input type="text" placeholder="Seçenekler" class="anketGroupOptions">
								</div>
								<!-- Kullanıcı şık ekleme alanı -->
								<div class="col-4 col-sm-6 col-md-5 col-lg-3 col-xl-2 text-center secenekAlan">
									<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
								</div>
							</div>
						</div>
						<div class="anketCoverager" name="1soru1">
							<div class="secretNum">
								<i class="secretNumFont fa-solid fa-1"></i>
							</div>
							<div class="anketSoru">
								<input type="text" placeholder="Soru" class="anketSoruVal">
							</div>
							<div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
								<input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' id="1soru1" checked>
								<label class="form-check-label anketZorunlulukLabel" for="1soru1" style="color:darkred;font-weight:bold">Zorunlu</label>
							</div>
							<!-- Kullanıcı soru ekleme alanı -->
							<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
							<span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
						</div>
					</div>
				</div>
				<div class="col-0 col-sm-2"></div>
			</div>

			<div class="row text-center">
				<div class="col-lg-2 col-sm-2 col-0"></div>
				<div class="col-lg-6 col-sm-4 col-6">
					<div class="flex mt-2" style="font-size: 14px;text-align:left;word-wrap: break-word;">
					<input class="form-check-input" type="checkbox" id="detaySormaAlan">
					<label class="form-check-label" for="detaySormaAlan">Kullanıcıdan yorum istensin mi ? <span class="text-muted">(Kullanıcının bu anket için düşünceleri sorulur.)</span></label>
					</div>
				</div>
				<div class="col-lg-2 col-sm-4  col-6" style="text-align:right">
					<button class="veriGonder btn btn-primary mt-4" type="button"><i class="fa-solid fa-plus"></i> Anketi Oluştur</button>
				</div>
				<div class="col-lg-2 col-sm-2  col-0"></div>
			</div>
		</div>
		<div class="col-0 col-sm-1 col-xl-2"></div>
	</div>
	<?php
	include_once 'includes/footer.php';
	?>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>