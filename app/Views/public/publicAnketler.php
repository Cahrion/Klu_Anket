<!doctype html>
<html lang="en">

<head>
    <title><?php echo $anketKaydi->baslik ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS v5.0.2 -->
    <base href="<?php echo base_url(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo base_url("css/publicAnketler.css"); ?>">
    <script src="<?php echo base_url("js/publicAnketler.js"); ?>"></script>
</head>

<body onload="baslat()">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Genel bilgilendirme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Anket formu herhangi bir kişisel bilgi içermemektedir.</li>
                        <li>Anket verilerinin güvenirliği açısından sadece kampüsler içinde erişim sağlanabilmektedir.</li>
                        <li>Anketin kimin doldurduğuna dair herhangi bir kişisel bilgiye erişmemek için link üzerinden erişilmektedir.</li>
                        <li>Ankete gönüllü olarak katılıp, cevaplarınızın gerçek görüşlerinizi yansıtması gerekir.</li>
                    </ul>
                    <p>Katılımınız için teşekkür ederiz.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Okudum</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="text-center mt-2 pb-2">
            <img src="<?php echo base_url("img/kluLogo.png") ?>" alt="KLU" title="KLU" width="100" height="100">
            <div class="anketBaslik">
                T.C. <br>
                KIRKLARELİ ÜNİVERSİTESİ <br>
                <?php echo $anketKaydi->baslik; ?>
            </div>
        </div>
        <?php
        if ($anketKaydi->metin != "") {
        ?>
            <div style="min-height:100px;border-bottom:1px dotted grey">
                <?php echo $anketKaydi->metin; ?>
            </div>
        <?php
        }
        ?>
        <div class="gorevBilgisi mt-3" style="border-bottom: 1px dotted grey;">
            <div class="mb-3 fakulteAlan" name="<?php echo $anketKaydi->anketKitle; ?>">
                <label for="fakulte" class="form-label" style="font-weight:bold">Görev fakülte yeriniz</label>
                <select class="form-select fakulteSelect" name="fakulte" id="fakulte" onchange="fakulteChange(this)">
                    <option class="fakulte" value="">Lütfen seçiniz</option>
                    <option class="fakulte" value="1">Muhendislik</option>
                    <option class="fakulte" value="2">Hukuk</option>
                </select>
            </div>
        </div>
        <?php
        if ($anketKaydi->aciklama != "") {
        ?>
            <div class="mt-5" style="min-height:100px;border-bottom:1px dotted grey">
                <div style="font-weight:bold">Açıklama</div>
                <?php echo $anketKaydi->aciklama; ?>
            </div>
        <?php
        }
        ?>
        <?php
        $anketUnSerializeVeri = unserialize($anketKaydi->serialize);
        foreach ($anketUnSerializeVeri as $ustKey => $anketGroup) { // $anketGroup -> [0][0] = renkAlani, [0][1] = Group Başlık, [0][2] = Group Metin, [1] => Seçenekler, [2] => Sorular
        ?>

            <?php
            if ($anketGroup[0][2] != "") {
            ?>
                <div style="min-height:100px" class="border border-secondary p-2">
                    <?php echo $anketGroup[0][2]; ?>
                </div>
            <?php
            }
            ?>
            <div class="table-responsive mb-4 anketAlan">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <?php

                            ?>
                            <th scope="col" class="text-<?php echo $anketGroup[0][0] == "rgb(0, 0, 0)" ? 'muted' : 'dark'; ?>" style="background-color:<?php echo $anketGroup[0][0] ?>;"><?php echo $anketGroup[0][1]; ?></th>
                            <?php
                            foreach ($anketGroup[1] as $anketSecenek) { // Seçenekler oluyor.
                                echo "<th scope='col' class='text-center'>$anketSecenek</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($anketGroup[2] as $key => $anketSoru) {
                        ?>
                            <tr>
                                <td class="soruBasligi">
                                    <?php
                                    if ($anketSoru[1] == "true") {
                                        $anketZorunluluk = "<span class='zorunluAlan' value='" . $ustKey . "-" . ($key + 1) . "'>(*)</span>";
                                    } else {
                                        $anketZorunluluk = "";
                                    }
                                    ?>
                                    <span class="soruMetni"><?php echo "<span style='font-weight:bold'>" . ($key + 1) . ". </span>" . $anketSoru[0]; ?></span>
                                    <?php echo $anketZorunluluk; ?>
                                </td>
                                <?php
                                foreach ($anketGroup[1] as $icKey => $anketSecenek) {
                                ?>
                                    <td class="soruCevaplari text-center">
                                        <input class="form-check-input soruSecenekler" type="radio" value="<?php echo ($key + 1) . "-" . $anketSecenek; ?>" name="<?php echo $ustKey . "-" . $key; ?>">
                                        <?php // checkbox sorunu yaşanmasın diye key bilgileriyle beraber gelicek veriyi özelleştirdik. 
                                        ?>
                                    </td>
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
        if($anketKaydi->anketGorus){
            ?>
            <div>
                <div style="font-weight: bold;border-bottom: 1px dotted grey;" class="mb-2">Diğer Bilgiler</div>
                <div>
                    <div>
                      <label for="anketGorus" class="form-label">Ayrıca belirtmek istediğiniz bir görüşünüz veya önerileriniz varsa kısaca yazınız.</label>
                      <textarea class="form-control" name="anketGorus" id="anketGorus" rows="3" onkeypress="anketGorusKeyPress(this)" onkeyup="anketGorusKeyPress(this)" onkeydown="anketGorusKeyPress(this)"></textarea>
                    </div>
                    <div class="text-end mb-3" style="font-size: 13px;">
                        <span class="Kullanilan">0</span> /
                        <span class="Maks">850</span>
                    </div>
                </div>
            
            </div>
            <?php
        }
        ?>
        <div class="text-primary mb-2">
            Anketi doldurduğunuz için teşekkür ederiz.
        </div>
        <div class="row mb-5">
            <div class="col-12 col-lg-6 col-xl-4 row">
                <div class="col-4" style="text-align:left">
                    <canvas id="guvenlikkodualani"></canvas>
                </div>
                <div class="col-2 col-xl-2" style="text-align:center">
                    <button onClick="degistir()" class="btn btn-secondary" style="height: 50px;"><i class="fa-solid fa-arrow-rotate-right"></i></button>
                </div>
                <div class="col-5 pl-3" style="text-align:left">
                    <input type="text" class="canvasSelector p-3"  style="height: 50px;" placeholder="Güvenlik kodu">
                </div>
            </div>
            <div class="col-0 col-lg-4 col-xl-6"></div>
            <div class="col-12 col-lg-2 col-xl-2">
                <div style="text-align:right">
                    <button type="button" class="publicAnketGonder btn btn-success" id="<?php echo $anketKaydi->id ?>">Anketi Gönder</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>