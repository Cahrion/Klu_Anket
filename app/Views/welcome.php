<!doctype html>
<html lang="en">
  <head>
	<title>Yonetim Giriş</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href="<?php echo base_url(); ?>">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="<?php echo base_url("js/welcome.js"); ?>"></script>
	<style>
		html{
			overflow-x: hidden;
		}
		.openMainBlock{
			padding: 20px;
			border: 1px solid grey;
			background: linear-gradient("blue", "green");
		}
	</style>
  </head>
  <body>
	  <div class="row mt-5 pt-5">
		  <div class="col-4"></div>
		  <div class="col-4">
				<div class="openMainBlock">
					<form action="<?php echo base_url("data/" . $klu_bilgi);?>" method="POST">
						<h1 class="text-center">Giriş Yap</h1>
						<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email"
							class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Email Adresiniz">
						</div>
						<div class="mb-3">
						<label for="password" class="form-label">Şifre</label>
						<input type="password"
							class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Şifreniz">
						</div>
						<input class="btn btn-secondary" type="submit" value="Giriş Yap">
					</form>
				</div>
		  </div>
		  <div class="col-4"></div>
	  </div>
	<!-- Bootstrap JavaScript Libraries -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>