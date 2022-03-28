<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $SiteLinki. "public/"?>css/publicAnketler.css">
</head>

<body>
    
<div class="container">
    <div class="text-center">
        <img src="<?php echo $SiteLinki. "public/"?>img/kluLogo.jpg" alt="KLU" title="KLU">
        <div class="anketBaslik">
            T.C. <br>
            KIRKLARELİ ÜNİVERSİTESİ <br>
            <?php echo $anketKaydi->baslik;?>
        </div>
    </div>
<?php
    $anketUnSerializeVeri = unserialize($anketKaydi->serialize);
    foreach($anketUnSerializeVeri as $anketGroup){ // $anketGroup -> [0][0] = renkAlani, [0][1] = Group Başlık, [0][2] = Group Metin, [1] => Seçenekler, [2] => Sorular
?>
        <div class="table-responsive my-5">
            <table class="table">
                <tr class="anketTabAlan">
                    <th colspan="10" class="text-center" style="background-color:<?php echo $anketGroup[0][0]?>;color:white" ><?php echo $anketGroup[0][1];?></th>
                    <?php
                        foreach($anketGroup[1] as $anketSecenek){
                            ?>
                                <th><?php echo $anketSecenek?></th>
                            <?php
                        }
                    ?>
                </tr>
                <?php
                    foreach($anketGroup[2] as $key => $anketSoru){
                        ?>
                            <tr>
                                <td colspan="10"><?php echo ($key+1) . ". " . $anketSoru?></td>
                                <?php
                                    foreach($anketGroup[1] as $icKey => $anketSecenek){
                                        ?>
                                            <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="<?php echo $key . "-" . $icKey;?>" id="<?php echo $key;?>" name="<?php echo $key;?>">
                                                </div>
                                            </td>
                                        <?php
                                    }
                                ?>
                            </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
        <?php
        
}
        ?>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>