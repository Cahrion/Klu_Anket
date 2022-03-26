<!doctype html>
<html lang="en">

<head>
	<title>Yonetim</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="css/Central.css">
	<script src="js/Central.js"></script>
</head>

<body>
	<div class="row">
		<div class="col-2 leftBar">
			<?php
			include_once 'includes/leftBar.php';
			?>
		</div>
		<div class="col-10">
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
				<div class="col-2 col-md-3"></div>
				<div class="col-8 col-md-6 mt-4 anketPlatform">
					<div class="GroupCoverager">
						<div class="anketGroupHeadCoverager">
							<div class="renkAlani"></div>
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
							<div class="anketSorular row">
								<div class="col-10">
									<input type="text" placeholder="Şıklar">
								</div>
								<!-- Kullanıcı şık ekleme alanı -->
								<div class="col-2 text-center">
									<button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
								</div>
							</div>
							<!-- Kullanıcı soru ekleme alanı -->
							<span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> + </span>
							<!-- 
							<span class="anketIcerigiEkle"></span>
							<span class="anketIcerigiEkle"></span> -->
						</div>
					</div>
				</div>
				<div class="col-2 col-md-3"></div>
			</div>

		</div>
	</div>
	<?php
	include_once 'includes/footer.php';
	?>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>