<!doctype html>
<html lang="en">

<head>
    <title><?php echo $anketKaydi->baslik?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $SiteLinki . "public/" ?>css/publicAnketler.css">
    <script src="<?php echo $SiteLinki . "public/" ?>js/publicAnketler.js"></script>
</head>

<body>
    <div class="container">
        <div class="text-center mt-5 pb-2" style="border-bottom:1px dotted grey">
            <img src="<?php echo $SiteLinki . "public/" ?>img/kluLogo.jpg" alt="KLU" title="KLU">
            <div class="anketBaslik">
                T.C. <br>
                KIRKLARELİ ÜNİVERSİTESİ <br>
                <?php echo $anketKaydi->baslik; ?>
            </div>
        </div>
        <?php
            if($anketKaydi->metin != ""){
                ?>
                    <div style="min-height:100px;border-bottom:1px dotted grey">
                        <?php echo $anketKaydi->metin;?>
                    </div>
                <?php
            }
        ?>
        <?php
            if($anketKaydi->metin != ""){
                ?>
                    <div style="min-height:100px;border-bottom:1px dotted grey">
                        <?php echo $anketKaydi->aciklama;?>
                    </div>
                <?php
            }
        ?>
        <?php
        $anketUnSerializeVeri = unserialize($anketKaydi->serialize);
        foreach ($anketUnSerializeVeri as $ustKey => $anketGroup) { // $anketGroup -> [0][0] = renkAlani, [0][1] = Group Başlık, [0][2] = Group Metin, [1] => Seçenekler, [2] => Sorular
        ?>
            <div class="row border border-secondary my-5 anketAlan">
                <?php
                    if($anketGroup[0][2] != ""){
                        ?>
                            <div class="col-12" style="min-height:100px">
                                <?php echo $anketGroup[0][2];?>
                            </div>
                        <?php
                    }
                ?>
                <div class="col-8 col-md-10 text-center anketTabAlan" style="background-color:<?php echo $anketGroup[0][0] ?>;color:white"><?php echo $anketGroup[0][1]; ?></div>
                <div class="col-4 col-md-2 anketTabAlan">
                    <div class="row text-center">
                        <?php
                        $gelenMiktar = count($anketGroup[1]);
                        $gelenYuzde  = 100 / $gelenMiktar;
                        foreach ($anketGroup[1] as $anketSecenek) {
                        ?>
                            <div style="width:<?php echo $gelenYuzde; ?>%" class="border border-secondary"><?php echo $anketSecenek ?></div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <?php
                foreach ($anketGroup[2] as $key => $anketSoru) {
                ?>
                    <div class="col-8 col-md-10 soruBasligi">
                        <?php echo ($key + 1) . ". " . $anketSoru[0] ?>
                    </div>
                    <div class="col-4 col-md-2 soruCevaplari">
                        <div class="row">
                            <?php
                            foreach ($anketGroup[1] as $icKey => $anketSecenek) {
                            ?>
                                <div style="width:<?php echo $gelenYuzde; ?>%" class="border border-secondary">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="<?php echo ($key+1) . "-" . $anketSecenek; ?>" name="<?php echo $ustKey . "-" . $key; ?>">
                                        <?php // checkbox sorunu yaşanmasın diye key bilgileriyle beraber gelcek veriyi özelleştirdik. ?>
                                    </div>
                                </div>
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
        }
        ?>
            <div class="d-grid gap-2 mb-5">
              <button type="button" class="btn btn-secondary" id="<?php echo $anketKaydi->id?>">Anketi Sonlandır.</button>
            </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>