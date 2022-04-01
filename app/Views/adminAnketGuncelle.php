<!doctype html>
<html lang="en">

<head>
	<title>Yonetim</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/"; ?>css/minRequire.css">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/"; ?>css/Central.css">
	<script src="<?php echo $SiteLinki . "public/"; ?>js/Central.js"></script>
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
					<input type="text" value="<?php echo $anketBilgisi->baslik ?>" placeholder="ANKET BAŞLIĞI">
				</div>
				<div class="baslikMetni">
					<textarea class="text-muted" cols="30" rows="10" placeholder="Detay bilgisini giriniz."><?php echo $anketBilgisi->metin ?></textarea>
				</div>
				<div class="aciklamaMetni">
					<textarea class="text-muted" cols="30" rows="10" placeholder="Anket hakkında açıklama yapınız."><?php echo $anketBilgisi->aciklama ?></textarea>
				</div>
				<div class="row">
					<div class="col-6 col-md-8 col-xl-9"></div>
					<div class="col-6 col-md-4 col-xl-3">
						<div class="form-check form-switch">
							<?php
								// Ternary Yapısıyla verinin onaylanıp onaylanmadığını sorguladık.
							?>
							<input class="form-check-input" type="checkbox" id="anketGirisZorunluluk" <?php echo $anketBilgisi->anketGiris?'checked':'';?> onclick='anketGirisZorunluluk(this)'> 
							<label class="form-check-label" for="flexSwitchCheckDefault" style="color: <?php echo $anketBilgisi->anketGiris?'red':'green';?>;font-weight:bold"> <?php echo $anketBilgisi->anketGiris?'Uyelik Şart':'Uyelik Şart Değil';?></label>
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
						<div class="GroupCoverager mt-4">
							<div class="anketGroupHeadCoverager">
								<?php
									if($keyGroup != 0){
										?>
											<span class="anketGroupSil" onclick="anketGroupSil(this)">G-</span>
										<?php
									}
								?>
								<div class="renkAlani" onclick='renkAlani(this)' style="background-color: <?php echo $gelenGroupCoveragerler[0][0] ?>"></div>
								<div class="baslik">
									<input type="text" value="<?php echo $gelenGroupCoveragerler[0][1] ?>" value="Group Başlığı">
								</div>
								<div class="baslikMetni">
									<textarea class="text-muted" cols="30" rows="10" placeholder="Detay bilgisini giriniz."><?php echo $gelenGroupCoveragerler[0][2] ?></textarea>
								</div>
								<?php
								foreach ($gelenGroupCoveragerler[1] as $keyOne => $gelenAnketSecenekler) {
								?>
									<div class="anketSecenekler row">
										<div class="col-10">
											<input type="text" value="<?php echo $gelenAnketSecenekler; ?>" placeholder="Seçenekler">
										</div>
										<!-- Kullanıcı şık ekleme alanı -->
										<?php
										if (count($gelenGroupCoveragerler[1]) == $keyOne + 1) { // Eğer son seçenek kısmındaysak seçenek ekleme başlıkları otomatikmen son olana eklensin.
										?>
											<div class="col-2 text-center">
												<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
											</div>
										<?php
										}
										?>
									</div>
								<?php
								}
								?>
							</div>
							<?php
							
							foreach ($gelenGroupCoveragerler[2] as $keyTwo => $gelenAnketCoveragerlar) { // [1] verisinde anket bölümü bulunmakta bizde onu tek tek açıyoruz.
							?>
								<div class="anketCoverager" style="border-left: 4px solid <?php echo $gelenGroupCoveragerler[0][0] ?>">
									<div class="anketSoru">
										<input type="text" value="<?php echo $gelenAnketCoveragerlar[0]; ?>" placeholder="Soru">
									</div>
									<div class="row mt-5">
										<div class="col-6 col-md-8 col-xl-9"></div>
										<div class="col-6 col-md-4 col-xl-3">
											<div class="form-check form-switch">
												<?php
													// Ternary Yapısıyla verinin onaylanıp onaylanmadığını sorguladık.
												?>
												<input class="form-check-input" type="checkbox" id="anketSoruZorunluluk" <?php echo $gelenAnketCoveragerlar[1] == 'true'?'checked':'';?> onclick='zorunlulukFaktor(this)'> 
												<label class="form-check-label" for="flexSwitchCheckDefault" style="color: <?php echo $gelenAnketCoveragerlar[1] == 'true'?'red':'green';?>;font-weight:bold"> <?php echo $gelenAnketCoveragerlar[1] == 'true'?'Zorunlu':'Serbest';?></label>
											</div>
										</div>
									</div>
									<!-- Kullanıcı soru ekleme alanı -->
									<?php
									if (count($gelenGroupCoveragerler[2]) == $keyTwo + 1) { // Eğer son Soru başlığındaysak soru ekleme başlıkları otomatikmen son olana eklensin.
									?>
										<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
										<span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
									<?php
									}
									?>
									<?php
										if(($keyTwo+1) != 1){
											?>
												<span class="anketIcerigiSil" onclick="anketIcerigiSil(this)">S-</span>
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
						<button id="veriGuncelle" type="button" class="btn btn-primary mt-4">Anketi Güncelle</button>
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