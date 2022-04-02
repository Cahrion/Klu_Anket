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
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/"; ?>css/minRequire.css">
	<link rel="stylesheet" href="<?php echo $SiteLinki . "public/"; ?>css/admin.css">
</head>

<body>
	<?php
	include_once 'includes/topBar.php';
	?>
	<div class="row kluCenter">
		<div class="col-0 col-sm-2"></div>
		<div class="col-12 col-sm-8 pt-3">

			<?php
			$SoruGrouplari 	= []; // Grouplar şeklinde datalarımızı tutalım
			$SoruVerileri 	= []; // Gelen soru şıklarını alalım
			$SoruMetinleri 	= []; // Gelen soru metinlerini alalım
			$anketUnSerialize = unserialize($anketBilgisi->serialize);
			foreach ($anketUnSerialize as $keyGroup => $anketGroup) { // Groupları aldık
				foreach ($anketGroup[2] as $keySoru => $anketSorular) { // Group içinde soruları aldık.
					$SoruMetinleri[$keySoru + 1] = $anketSorular;
					foreach ($anketGroup[1] as $gelenSoruSecenekler) { // Group içine seçenekleri yazdırdık ve puanları 0 yaptık (İşaretlenmemiş anlamında.)
						$SoruVerileri[$keySoru + 1][$gelenSoruSecenekler] = 0;
					}
				}
				$SoruGrouplari[$keyGroup] = [$SoruMetinleri, $SoruVerileri]; // Elimizdeki verileri düzenli bir şekilde ana grup yapısına ekledik.
				$SoruVerileri             = [];
				$SoruMetinleri            = []; // Sistemde yeni veriler üst üste gelmesin diye eski verileri siliyoruz.
			}

			foreach ($publicVeri as $publicRowVeri) { // getResult() yapısıyla geldiği için öncelikle bir foreach döngüsüne girelim.
				$gelenUnSerializeVeri = unserialize($publicRowVeri->serialize);
				foreach ($gelenUnSerializeVeri as $keyGroup => $gelenGroupVeri) { // İlk döngüde Grouplar geldiği için grupları alalım.
					foreach ($gelenGroupVeri as $keySoru => $gelenSoruVeri) { // Soruları alalım.
						$ayracSoru = explode("-", $gelenSoruVeri); // Sorular (SoruNumarası-SoruCevabı) olarak geldiği için explode() ile bölelim
						$SoruGrouplari[$keyGroup][1][$ayracSoru[0]][$ayracSoru[1]] += 1; // Burada soru numarası ve soru cevabına eşit gelen değere ekleme yaptık.
					}
				}
			}
			?>

			<div class="row">
				<div class="col-10">
					<div class="border border-secondary p-4">Toplam <?php echo count($publicVeri)?> kişi anket doldurmuştur. Sonuçları aşağıdaki gibidir.</div>
				</div>
				<div class="col-2 text-center mt-3">
					<a href="<?php echo $SiteLinki . "public/ownerController/anketAnalizExcel"?>" class="btn btn-success"><i class='dwn'><i>Export</a>
				</div>
			</div>

			
			<?php
			foreach ($anketUnSerialize as $keyGroup => $anketGroup) {
			?>
				<div class="table-responsive my-4">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">Soru</th>
								<?php
								foreach ($anketGroup[1] as $gelenSoruSecenekler) { // Seçenekler oluyor.
									echo "<th scope='col'>$gelenSoruSecenekler</th>";
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($SoruGrouplari[$keyGroup][0] as $keySoru => $soru){
									?>
										<tr>
											<td>
												<?php echo $soru[0];?>
											</td>
											<?php
												foreach($SoruGrouplari[$keyGroup][1][$keySoru] as $secenekler){
													?>	
														<td><?php echo $secenekler;?></td>
													<?php
												}
											?>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
			<?php
			}

			?>
		</div>
		<div class="col-0 col-sm-2"></div>
	</div>
	<?php
	include_once 'includes/footer.php';
	?>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>