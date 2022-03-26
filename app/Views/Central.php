<!doctype html>
<html lang="en">
  <head>
	<title>Yonetim</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<style>
		html{
			overflow-x: hidden;
		}
		input:focus{
			outline: none;
			border: none;
		}
		.anketHeadCoverager{
			padding: 10px;
			border: 1px solid grey;
			border-radius: 5px;
			min-height: 150px;
			width: 100%;
			border-left: 4px solid blue;
		}
		.anketCoverager{
			position: relative;
			padding: 10px;
			border: 1px solid grey;
			border-radius: 5px;
			min-height: 200px;
			width: 100%;
			border-left: 4px solid black;
			margin-top: 20px;
		}
		.baslik{
			border-bottom: 1px dotted grey;
		}
		.baslik input{
			border: 0;
			width: 100%;
			height: 50px;
			font-size: large;
			font-weight: bold;
			padding-left: 10px;
			padding-right: 10px;
		}
		.baslikMetni{
			margin-top: 10px;
		}
		.baslikMetni textarea{
			border: 0;
			width: 100%;
			height: 50px;
			font-size: large;
			font-weight: bold;
			padding-left: 10px;
			padding-right: 10px;
		}
		.baslikMetni textarea:focus{
			outline: none;
			border: none;
		}
		.anketIcerigiEkle{
			transition: all 1s;
			position: absolute;
			top: 10px;
			right: -50px;
			border: 1px solid grey;
			border-radius: 5px;
			width: auto;
			padding: 10px;
		}
		.anketIcerigiEkle:hover{
			cursor: pointer;
			background-color: grey;
			color: white;
			border: 1px solid white;
			transform: scale(1.2);
		}
		.anketSorular{
			margin-top: 10px;
		}
		.anketSorular input{
			width: 100%;
			border: 0;
			height: 50px;
			padding-left: 10px;
			padding-right: 10px;
		}
		.anketSorular input:hover{
			border-bottom: 1px dotted grey;
		}
		.anketSorular input:focus{
			border-bottom: 1px solid grey;
		}
	</style>
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
				<div class="row">
					<div class="col-2 col-md-3"></div>
					<div class="col-8 col-md-6 mt-4">
						<div class="anketHeadCoverager">
							<div class="baslik">
								<input type="text" value="ANKET BAŞLIĞI">
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
									<button class="btn btn-primary">+</button>
								</div>
							</div>
							<!-- Kullanıcı soru ekleme alanı -->
							<span class="anketIcerigiEkle"> + </span>
							<!-- 
							<span class="anketIcerigiEkle"></span>
							<span class="anketIcerigiEkle"></span> -->
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