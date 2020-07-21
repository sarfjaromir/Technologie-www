<!DOCTYPE html>
<?php
// Semestrální úkol - Jaromír Šarf
include 'knihovna.php';
hlavicka('Admin');
?>
<body>
  <div class="content">
    <div class="container">
      <div class="row kurty_box">
<?php
menu(5);
function vypisPrihlaseni(){
  echo "<div class=\"container\">";
  echo "<div class=\"row\">";
  echo "<div class=\" admin_login col-12\">";
  echo "<form action=\"admin_prihlaseni.php\" method=\"POST\">";
    echo "<input type=\"text\" name=\"jmeno\" placeholder=\"Jméno\">";
    echo "<input type=\"password\" name=\"heslo\" placeholder=\"Heslo\">";
    echo "<input type=\"submit\" name=\"prihlasit\" value=\"Přihlásit\">";
  echo "</form>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
function crud(){
  if(isset($_POST["den"])){
    $den = $_POST["den"];
  }else{
    $den = 0;
  }
    ?>
    <div class="container admin_login">
      <div class="row">
      <div class="col-12">
        <div class="col-4 vlevo">
    <form action="admin_prihlaseni.php" method="post">
      <input type="submit" name="sipkavpravo" value="<-">
      <input type="hidden" name="jmeno" value="<?php echo $_POST['jmeno']?>">
      <input type="hidden" name="heslo" value="<?php echo $_POST['heslo']?>">
      <input type="hidden" name="den" value="<?php echo ($den - 1)?>">
      <input type="hidden" name="prihlasit" value="prihlasit">
    </form>
  </div>
  <div class="col-4 datum">
  <?php
  echo "Rezervace na den ".date("d. m. Y", time() + $den*86400);
  ?>
  </div>
  <div class="vpravo">
    <form action="admin_prihlaseni.php" method="post">
      <input type="submit" name="sipkavpravo" value="->">
      <input type="hidden" name="jmeno" value="<?php echo $_POST['jmeno']?>">
      <input type="hidden" name="heslo" value="<?php echo $_POST['heslo']?>">
      <input type="hidden" name="den" value="<?php echo ($den + 1)?>">
      <input type="hidden" name="prihlasit" value="prihlasit">
    </form>
  </div>
</div>
<div class="col-12 admin_data">
<form action="admin_prihlaseni.php" method="post">
<input type="hidden" name="jmeno" value="<?php echo $_POST['jmeno']?>">
<input type="hidden" name="heslo" value="<?php echo $_POST['heslo']?>">
<input type="hidden" name="den" value="<?php echo $den?>">
<input type="hidden" name="prihlasit" value="prihlasit">
    <?php
  $poleId = vypisRezervaceAdmin(date("Y-m-d",time() + $den * 86400));
  ?>
</div>
</div>
</div>
  <?php
  foreach($poleId as $item){
    if(isset($_POST[$item])){
      OdeberRezervaci($item);
        ?>
        <script>window.location.reload(true);</script>
        <?php
    }
  }
  ?>
  <div class="col-12 odhlasit">
    <div class="vlevo">
        <input type="submit" name="ulozit" value="Uložit">
        <input type="hidden" name="jmeno" value="<?php echo $_POST['jmeno']?>">
        <input type="hidden" name="heslo" value="<?php echo $_POST['heslo']?>">
        <input type="hidden" name="den" value="<?php echo $den?>">
        <input type="hidden" name="prihlasit" value="prihlasit">
      </form>
    </div>
    <div class="vpravo">
      <form action="admin_prihlaseni.php" method="post">
        <input type="submit" value="Odhlásit">
      </form>
    </div>
  </div>
  <?php
  if(isset($_POST['ulozit'])){
    foreach($poleId as $item){
      echo "<div class=\"col-12\">";
      UpravRezervaci($item, $_POST['jmeno'.$item], $_POST['prijmeni'.$item], $_POST['email'.$item], $_POST['telefon'.$item], $_POST['cas'.$item], $_POST['id_kurt'.$item]);
      echo "</div>";
    }
  }
}
//MAIN
if(isset($_POST['prihlasit'])){
  if(isset($_POST['jmeno']) && $_POST['jmeno'] == 'admin'){
    if(isset($_POST['heslo']) && $_POST['heslo'] == 'admin'){
      crud();
    }else{
      vypisPrihlaseni();
      echo "Jméno nebo heslo bylo zadáno chybně.";
    }
  }else{
    vypisPrihlaseni();
    echo "Jméno nebo heslo bylo zadáno chybně.";
  }
}else{
  vypisPrihlaseni();
}
paticka();
 ?>
      </div>
    </div>
  </div>
</body>
</html>
