<?php
// Semestrální úkol - Jaromír Šarf
 include 'knihovna.php';
 hlavicka("Rezervace ");
?>
<body>
  <div class="content">
    <div class="container">
      <div class="row kurty_box">
        <?php menu(1);
if(isset($_GET["datum"]) || isset($_GET['odeslat'])){
  $datum = $_GET["datum"];
  if((bool)strtotime($datum) || isset($_GET['odeslat'])){
    $datum_url = date_create($datum);
    $datum_ted = date_create(date("Y-m-d"));
    $rozdil = date_diff($datum_url, $datum_ted)->format('%a');
    if(($rozdil < 14 && $rozdil >= 0 && $datum_url >= $datum_ted) || isset($_GET['odeslat'])){
      ?>
        <div class="nadpis_rezervace col-12">
          <h2>Rezervace dne: <?php echo $datum_url->format('d. m. Y') ?></h2>
          <h3><?php echo $_GET['cas'].":00 - ".($_GET['cas'] + 1).":00" ?></h3>
        </div>
        <div class="formular">
          <form method="GET" action="formular.php?<?php echo http_build_query($data) ?>">
            <div class="col-12">
              <input type="text" name="jmeno" placeholder="Jméno">
            </div>
            <div class="col-12">
              <input type="text" name="prijmeni"placeholder="Příjmení">
            </div>
            <div class="col-12">
              <input type="email" name="email" placeholder="E-mail">
            </div>
            <div class="col-12">
              <input type="tel" name="telefon" placeholder="Telefonní číslo">
            </div>
            <input type="hidden" name="datum" value="<?php echo $_GET['datum']?>">
            <input type="hidden" name="cas" value="<?php echo $_GET['cas']?>">
            <input type="hidden" name="kurt" value="<?php echo $_GET['kurt']?>">
            <div class="col-12">
              <input type="submit" class="submit" name="odeslat" value="Odeslat">
            </div>
          </form>
        </div>
      </body>
      <?php
    if(isset($_GET['odeslat'])){
        $chyba = 0;
        if(!isset($_GET['jmeno']) || strlen($_GET['jmeno']) == 0){
          echo "Chyba: Jmeno neni zadano<br>";
          $chyba = 1;
        }
        if(!isset($_GET['prijmeni']) || strlen($_GET['prijmeni']) == 0){
          echo "Chyba: Prijmeni neni zadano<br>";
          $chyba = 1;
        }
        if(!isset($_GET['email'])){
          echo "Chyba: E-mail neni zadan<br>";
          $chyba = 1;
        }
        if(!isset($_GET['telefon'])){
          echo "Chyba: Telefon neni zadan<br>";
          $chyba = 1;
        }
        if(!is_numeric($_GET['telefon'])){
          echo "Chyba: Telefon neni cislo";
          $chyba = 1;
        }
        if($chyba == 0){
          pridejRezervaci($_GET['kurt'], $_GET['jmeno'], $_GET['prijmeni'], $_GET['email'], $_GET['telefon'], $_GET['cas'], $_GET['datum']);
          print '<script type="text/javascript">alert("Rezervace byla uspesne vlozena");</script>';
          print '<script type="text/javascript">window.location.replace("rezervace.php");</script>';
        }
      }
    }else{
      echo "Datum je mimo interval";
    }
  }else{
    echo "Parametr datum neni v casovem formatu";
  }
}else{
  echo "Parametr datum nenastaven";
}
paticka();
?>
        </div>
      </div>
    </div>
  </body>
</html>
