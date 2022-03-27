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
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/";?>css/minRequire.css">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/";?>css/Central.css">
	<script src="<?php echo $SiteLinki . "public/";?>js/Central.js"></script>
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
					<input type="text" value="ANKET BAŞLIĞI">
				</div>
				<div class="baslikMetni">
					<textarea class="text-muted" cols="30" rows="10">Detay bilgisini giriniz</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8 anketPlatform">
					<div class="GroupCoverager mt-4">
						<div class="anketGroupHeadCoverager">
                			<div class="renkAlani" onclick='renkAlani(this)'></div>
							<div class="baslik">
								<input type="text" value="Group Başlığı">
							</div>
							<div class="baslikMetni">
								<textarea class="text-muted" cols="30" rows="10">Detay bilgisini giriniz</textarea>
							</div>
						</div>
						<div class="anketCoverager">
							<div class="baslik">
								<input type="text" placeholder="Soru Başlığı">
							</div>
							<div class="anketSecenekler row">
								<div class="col-10">
									<input type="text" placeholder="Seçenekler">
								</div>
								<!-- Kullanıcı şık ekleme alanı -->
								<div class="col-2 text-center">
									<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
								</div>
							</div>
							<!-- Kullanıcı soru ekleme alanı -->
							<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
							<span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
							<!-- 
							<span class="anketIcerigiEkle"></span> -->
						</div>
					</div>
				</div>
				<div class="col-0 col-sm-2"></div>
			</div>
			
			<div class="row">
				<div class="col-0 col-sm-2"></div>
				<div class="col-12 col-sm-8" style="text-align:right">
					<button id="veriGonder" type="button" class="btn btn-primary mt-4">Anketi Oluştur</button>
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