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
			<div class="anketHeadCoverager mt-4" id="<?php echo $anketBilgisi->id ?>">
				<div class="baslik">
					<input type="text" value="<?php echo $anketBilgisi->baslik ?>" placeholder="ANKET BAŞLIĞI" class="anketHeadCoveragerHeader">
				</div>
				<div class="baslikMetni">
					<textarea class="text-muted anketHeadCoveragerHeadText" cols="30" rows="10" placeholder="Detay bilgisini giriniz."><?php echo $anketBilgisi->metin ?></textarea>
				</div>
				<div class="aciklamaMetni">
					<textarea class="text-muted anketHeadCoveragerExplanationText" cols="30" rows="10" placeholder="Anket hakkında açıklama yapınız."><?php echo $anketBilgisi->aciklama ?></textarea>
				</div>

				<div class="row formAlanKapsayici">
					<div class="col-8 formKitle">
						<select class="form-select mb-3" id="formKitleSelected">
							<option value="">Anket Kimler Tarafından Doldurulacak?</option>
							<option value="akademik" <?php echo $anketBilgisi->anketKitle == "akademik" ? "selected" : ""; ?>>Akademik Personeller</option>
							<option value="idari" <?php echo $anketBilgisi->anketKitle == "idari" ? "selected" : ""; ?>>İdari Personeller</option>
							<option value="ogrenci" <?php echo $anketBilgisi->anketKitle == "ogrenci" ? "selected" : ""; ?>>Ögrenciler</option>
							<option value="herkes" <?php echo $anketBilgisi->anketKitle == "herkes" ? "selected" : ""; ?>>Herkes</option>
						</select>
					</div>
					<div class="col-4 formCheck">
						<div class="form-check form-switch formAlan" style="float: right;">
							<?php
							// Ternary Yapısıyla verinin onaylanıp onaylanmadığını sorguladık.
							?>
							<input class="form-check-input" type="checkbox" id="anketGirisZorunluluk" <?php echo $anketBilgisi->anketGiris ? 'checked' : ''; ?> onclick='anketGirisZorunluluk(this)'>
							<label class="form-check-label" for="anketGirisZorunluluk" style="color:black;font-weight:bold;">Eposta ile Girişi Zorunlu Tut
								<span style="font-size:10px;display:block" class="text-muted">(Sadece klu.edu.tr uzantılı e-postaya sahip olanlar girebilir.)</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8 anketPlatform">
					<?php
					$gelenUnSerializeVeri = unserialize($anketBilgisi->serialize);
					foreach ($gelenUnSerializeVeri as $keyGroup => $gelenGroupCoveragerler) { // [0][0] = renkAlani, [0][1] = Group başlığı, [0][2] = Group Detay Metni, [1] => Seçenekler, [2] => Sorular
					?>
						<div class="GroupCoverager mt-4" name="<?php echo ($keyGroup+1)?>">
							<div class="anketGroupHeadCoverager">
								<?php
								if ($keyGroup != 0) {
								?>
									<span class="anketGroupSil" onclick="anketGroupSil(this)">Grup Sil</span>
								<?php
								}
								?>
								<div class="renkAlani" onclick='renkAlani(this)' style="background-color: <?php echo $gelenGroupCoveragerler[0][0] ?>"></div>
								<div class="baslik">
									<input type="text" value="<?php echo $gelenGroupCoveragerler[0][1] ?>" value="Group Başlığı" class="anketGroupHeadCoveragerHeader">
								</div>
								<div class="baslikMetni">
									<textarea class="text-muted anketGroupHeadCoveragerHeadText" cols="30" rows="10" placeholder="Detay bilgisini giriniz."><?php echo $gelenGroupCoveragerler[0][2] ?></textarea>
								</div>
								<?php
								foreach ($gelenGroupCoveragerler[1] as $keyOne => $gelenAnketSecenekler) {
								?>
									<div class="anketSecenekler row" name="<?php echo ($keyGroup+1)."secenek".($keyOne+1)?>">
										<div class="col-8 col-sm-6 col-md-7 col-lg-9 col-xl-10 anketSeceneklerIcAlan">
											<input type="text" value="<?php echo $gelenAnketSecenekler; ?>" placeholder="Seçenekler" class="anketGroupOptions">
										</div>
										<!-- Kullanıcı şık ekleme alanı -->
										<div class="col-4 col-sm-6 col-md-5 col-lg-3 col-xl-2 text-center secenekAlan">
											<?php
											if ($keyOne != 0) {
											?>
												<button class="btn btn-primary soruSecenekSil" onclick="soruSecenekSil(this)"><i class="fa-solid fa-minus"></i></button>
											<?php
											}
											?>
											<?php
											if (count($gelenGroupCoveragerler[1]) == $keyOne + 1) { // Eğer son seçenek kısmındaysak seçenek ekleme başlıkları otomatikmen son olana eklensin.
											?>
												<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
											<?php
											}
											?>
										</div>
									</div>
								<?php
								}
								?>
							</div>
							<?php

							foreach ($gelenGroupCoveragerler[2] as $keyTwo => $gelenAnketCoveragerlar) { // [1] verisinde anket bölümü bulunmakta bizde onu tek tek açıyoruz.
							?>

								<div class="anketCoverager" style="border-left: 4px solid <?php echo $gelenGroupCoveragerler[0][0] ?>" name="<?php echo ($keyGroup+1)."soru".($keyTwo+1)?>">
									<div class="secretNum">
										<?php
											if(($keyTwo+1) < 10){
												$secretNumVal = $keyTwo+1;
												echo '<i class="secretNumFont fa-solid fa-' . $secretNumVal . '"></i>';
											}else if( (($keyTwo+1) < 100) and (($keyTwo+1) >= 10) ){
												$keySecretNum = strval($keyTwo+1);
												echo '<i class="secretNumFont fa-solid fa-' . $keySecretNum[0] . '"></i>';
												echo '<i class="secretNumFont fa-solid fa-' . $keySecretNum[1] . '"></i>';
											}else if( (($keyTwo+1) < 1000) and (($keyTwo+1) >= 100) ){
												$keySecretNum = strval($keyTwo+1);
												$secretNumVal = explode("", $keySecretNum);
												echo '<i class="secretNumFont fa-solid fa-' . $keySecretNum[0] . '"></i>';
												echo '<i class="secretNumFont fa-solid fa-' . $keySecretNum[1] . '"></i>';
												echo '<i class="secretNumFont fa-solid fa-' . $keySecretNum[2] . '"></i>';
											}
										?>										
										
									</div>
									<div class="anketSoru">
										<input type="text" value="<?php echo $gelenAnketCoveragerlar[0]; ?>" placeholder="Soru" class="anketSoruVal">
									</div>
									<div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
										<?php
										// Ternary Yapısıyla verinin onaylanıp onaylanmadığını sorguladık.
										?>
										<input class="form-check-input anketSoruZorunluluk" type="checkbox" <?php echo $gelenAnketCoveragerlar[1] == 'true' ? 'checked' : ''; ?> onclick='zorunlulukFaktor(this)'  id="<?php echo ($keyGroup+1)."soru".($keyTwo+1)?>">
										<label class="form-check-label" for="<?php echo ($keyGroup+1)."soru".($keyTwo+1)?>" style="color:<?php echo $gelenAnketCoveragerlar[1] == 'true' ? "darkred" : "#c0c5c0"; ?>;font-weight:bold">Zorunlu</label>
									</div>
									<!-- Kullanıcı soru ekleme alanı -->
										<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
									<?php
									if (count($gelenGroupCoveragerler[2]) == $keyTwo + 1) { // Eğer son Soru başlığındaysak soru ekleme başlıkları otomatikmen son olana eklensin.
									?>
										<span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
									<?php
									}
									?>
									<?php
									if (($keyTwo + 1) != 1) {
									?>
										<span class="anketIcerigiSil" onclick="anketIcerigiSil(this)">Soru Sil</span>
									<?php
									}
									?>
								</div>
							<?php
							}
							?>
						</div>
					<?php
					}
					?>
				</div>
				<div class="col-0 col-sm-2"></div>
				<div class="row">
					<div class="col-0 col-sm-2"></div>
					<div class="col-12 col-sm-8" style="text-align:right">
						<button id="veriGuncelle" type="button" class="btn btn-primary mt-4"><i class="fa-solid fa-plus"></i> Anketi Güncelle</button>
					</div>
					<div class="col-0 col-sm-2"></div>
				</div>
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