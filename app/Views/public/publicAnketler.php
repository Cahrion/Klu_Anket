<!doctype html>
<html lang="en">

<head>
    <title><?php echo $anketKaydi->baslik ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $SiteLinki . "public/" ?>css/publicAnketler.css">
    <script src="<?php echo $SiteLinki . "public/" ?>js/publicAnketler.js"></script>
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
        <div class="text-center mt-5 pb-2" style="border-bottom:1px dotted grey">
            <img src="<?php echo $SiteLinki . "public/" ?>img/kluLogo.jpg" alt="KLU" title="KLU">
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
        <div class="gorevBilgisi">
            <div class="mb-3 bransAlan">
                <label for="brans" class="form-label">Kimlik</label>
                <select class="form-control bransSelect" name="brans" id="brans" onchange="bransChange(this)">
                    <option class="brans" value="">Lütfen seçiniz.</option>
                    <?php
                    if (!$anketKaydi->anketGiris) {
                    ?>
                        <option class="brans" value="ogrenci">Ögrenci</option>
                    <?php
                    }
                    ?>
                    <option class="brans" value="akademik">Akademik</option>
                    <option class="brans" value="idari">İdari</option>
                </select>
            </div>
        </div>
        <?php
        if ($anketKaydi->aciklama != "") {
        ?>
            <div style="min-height:100px;border-bottom:1px dotted grey">
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
                            <th scope="col" class="text-muted" style="background-color:<?php echo $anketGroup[0][0] ?>;"><?php echo $anketGroup[0][1]; ?></th>
                            <?php
                            foreach ($anketGroup[1] as $anketSecenek) { // Seçenekler oluyor.
                                echo "<th scope='col'>$anketSecenek</th>";
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
                                        $anketZorunluluk = "<span class='zorunluAlan' value='" . $ustKey . "-" . $key + 1 . "'>(*)</span>";
                                    } else {
                                        $anketZorunluluk = "";
                                    }
                                    ?>
                                    <span class="soruMetni"><?php echo ($key + 1) . ". " . $anketSoru[0]; ?></span>
                                    <?php echo $anketZorunluluk; ?>
                                </td>
                                <?php
                                foreach ($anketGroup[1] as $icKey => $anketSecenek) {
                                ?>
                                    <td class="soruCevaplari">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="<?php echo ($key + 1) . "-" . $anketSecenek; ?>" name="<?php echo $ustKey . "-" . $key; ?>">
                                            <?php // checkbox sorunu yaşanmasın diye key bilgileriyle beraber gelicek veriyi özelleştirdik. 
                                            ?>
                                        </div>
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
        ?>
        <div>Güvenlik Kodu: </div>
        <br>
        <div class="row col-md-10 col-lg-8 col-xl-6">
            <div class="col-6 col-md-4 col-lg-3">
                <canvas id="guvenlikkodualani" width="150" height="50"></canvas>
            </div>
            <div class="col-6 col-md-4 col-lg-6">
                <input type="text" class="canvasSelector" placeholder="Güvenlik kodunu giriniz.">
            </div>
            <div class="col-12 col-md-4 col-lg-3 mt-1">
                <button onClick="degistir()" class="btn btn-primary mt-1">Yeni kod iste</button>
            </div>
        </div>

        <div class="d-grid gap-2 mb-5 mt-2">
            <button type="button" class="publicAnketGonder btn btn-secondary" id="<?php echo $anketKaydi->id ?>">Anketi Sonlandır.</button>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>