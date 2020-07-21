<!DOCTYPE html>
<?php
// Semestrální úkol - Jaromír Šarf
 include 'knihovna.php';
 hlavicka("Rezervace ");
 ?>
<body>
  <?php
  function vypisCasyKurtu($id_kurt, $den){
    $pole = vratRezervace(date("Y-m-d",time() + $den * 86400), $id_kurt);
    for($i = 6; $i < 20; $i++){
      $ano = 0;
      foreach($pole as $polozka){
        if($polozka == $i){
          $ano = 1;
          break;
        }
      }
      $cas = date('H') + 2;
      if($ano == 1){
        echo "<a><div class=\"kurt_cas_obsazeno\">".$i."-".($i+1)."</div></a>";
      }else if(($cas >= $i) && ($den == 0)){
        echo "<a><div class=\"kurt_cas\">".$i."-".($i+1)."</div></a>";
      }else{
        echo "<a href=\"formular.php?datum=".date("Y-m-d",time() + $den * 86400)."&cas=".$i."&kurt=".$id_kurt."\"><div class=\"kurt_cas\">".$i."-".($i+1)."</div></a>";
      }
    }
  }
    if(isset($_POST['den'])){
      $den = $_POST['den'];
      if($den < 0){
        $den = 0;
      }else if($den > 14){
        $den = 14;
      }
    }else{
      $den = 0;
    }
  ?>
  <div class="content">
    <div class="container">
      <div class="row kurty_box">
        <?php menu(1); ?>
        <div class="col-12">
          <h2>Rezervace</h2>
        </div>
        <div class="col-12">
        <div class="col-4 vlevo">
          <form action="rezervace.php" method="post">
            <input type="submit" name="sipkavpravo" value="<-">
            <input type="hidden" name="den" value="<?php echo ($den - 1)?>">
            <input type="hidden" name="prihlasit" value="prihlasit">
          </form>
        </div>
        <div class="col-4 datum">
          <?php
          echo "<h3>".date("d. m. Y", time() + $den*86400)."</h3>";
          ?>
        </div>
        <div class="vpravo">
          <form action="rezervace.php" method="post">
            <input type="submit" name="sipkavpravo" value="->">
            <input type="hidden" name="den" value="<?php echo ($den + 1)?>">
            <input type="hidden" name="prihlasit" value="prihlasit">
          </form>
        </div>
        </div>

        <div class="col-md-4 kurt1">
          <h3>Kurt č.1</h3>
          <div class="kurt_content">
          <?php
          vypisCasyKurtu(1, $den);
           ?>
         </div>
        </div>
        <div class="col-md-4 kurt2">
          <h3>Kurt č.2</h3>
          <div class="kurt_content">
          <?php
          vypisCasyKurtu(2, $den);
           ?>
         </div>
        </div>
        <div class="col-md-4 kurt3">
          <h3>Kurt č.3</h3>
          <div class="kurt_content">
          <?php
            vypisCasyKurtu(3, $den);
           ?>
         </div>
        </div>
        <?php paticka(); ?>

      </div>
    </div>
  </div>
</body>
</html>
