<?php
// Semestrální úkol - Jaromír Šarf
function hlavicka($title){
  echo "<head>";
  echo "<title>Tenisové kurty - ".$title."</title>";
  echo "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\"
  integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">";
  echo "<link rel=\"stylesheet\" href=\"styly.css\">";
  echo "</head>";
}

function menu($vyber){
  echo "<div class=\"col-12 nadpis\">";
  echo "<h1>Tenisové kurty</h1>";
  echo "</div>";
  echo "<div class=\"col-sm-12 menu\">";
  echo "<ul>";
  if($vyber == 0){
    echo "<a href=\"index.php\"><li class=\"menu_vyber\">Úvod</li></a>";
  }else{
    echo "<a href=\"index.php\"><li>Úvod</li></a>";
  }
  if($vyber == 1){
    echo "<a href=\"rezervace.php\"><li class=\"menu_vyber\">Rezervace</li></a>";
  }else{
    echo "<a href=\"rezervace.php\"><li>Rezervace</li></a>";
  }
  if($vyber == 2){
    echo "<a href=\"cenik.php\"><li class=\"menu_vyber\">Ceník</li></a>";
  }else{
    echo "<a href=\"cenik.php\"><li>Ceník</li></a>";
  }
  if($vyber == 3){
    echo "<a href=\"kontakt.php\"><li class=\"menu_vyber\">Kontakt</li></a>";
  }else{
    echo "<a href=\"kontakt.php\"><li>Kontakt</li></a>";
  }
  if($vyber == 5){
    echo "<a href=\"admin_prihlaseni.php\"><li class=\"menu_vyber\">Admin</li></a>";
  }else{
    echo "<a href=\"admin_prihlaseni.php\"><li>Admin</li></a>";
  }
  echo "</ul>";
  echo "</div>";
}

function paticka(){
  echo "<div class=\"col-12 paticka\">";
  echo"Semestrální projekt - Jaromír Šarf";
  echo"</div>";
}

function pripojDatabazi(){
  $odkaz = mysqli_connect("localhost", "root", "1234567890");
  if($odkaz === false){
    exit("ERROR: Could not connect. " . mysqli_connect_error());
  }else{
    mysqli_query($odkaz, "USE databaze");
    return $odkaz;
  }
}

function odpojDatabazi($odkaz){
  mysqli_close($odkaz);
}

function vypisRezervaceAdmin($datum){
  $odkaz = pripojDatabazi();
  $sql = "SELECT * FROM rezervace WHERE datum ='$datum' ORDER BY id_kurt, cas";
  $poleId = array();
  if($result = mysqli_query($odkaz, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
              echo "<th>ID</th>";
              echo "<th>Jméno</th>";
              echo "<th>Příjmení</th>";
              echo "<th>E-mail</th>";
              echo "<th>Telefon</th>";
              echo "<th>Čas</th>";
              echo "<th>Kurt</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            array_push($poleId, $row['id_rezervace']);
            echo "<tr>";
                echo "<td>" . $row['id_rezervace'] . "</td>";
                echo "<td><input name=\"jmeno".$row['id_rezervace']."\" type=\"text\" class=\"upravitInput\" value=". $row['jmeno'] . "></td>";
                echo "<td><input name=\"prijmeni".$row['id_rezervace']."\" type=\"text\" class=\"upravitInput\" value=" . $row['prijmeni'] . "></td>";
                echo "<td><input name=\"email".$row['id_rezervace']."\" type=\"email\" class=\"upravitInput\" value=" . $row['email'] . "></td>";
                echo "<td><input name=\"telefon".$row['id_rezervace']."\" type=\"text\" class=\"upravitInput\" value=" . $row['telefon'] . "></td>";
                echo "<td><input name=\"cas".$row['id_rezervace']."\" type=\"text\" class=\"upravitInput\" value=" . $row['cas'] . "></td>";
                echo "<td><input name=\"id_kurt".$row['id_rezervace']."\" type=\"text\" class=\"upravitInput\" value=". $row['id_kurt'] . "></td>";
                echo "<td><input type=\"submit\" name=\"".$row['id_rezervace']."\" value=\"Smazat\"></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
    } else{
        echo "Nejsou dostupné žádné záznamy";
    }
  }
  return $poleId;
  odpojDatabazi($odkaz);
}

function vratRezervace($datum, $id_kurt){
  $odkaz = pripojDatabazi();
  $pole[] = "";
  $sql = "SELECT * FROM rezervace WHERE datum='$datum' AND id_kurt=$id_kurt";
  if($result = mysqli_query($odkaz, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          array_push($pole, $row['cas']);
        }
        mysqli_free_result($result);
    }
  }else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($odkaz);
  }
  odpojDatabazi($odkaz);
  return $pole;
}

function pridejRezervaci($id_kurt, $jmeno, $prijmeni, $email, $telefon, $cas, $datum){
  $odkaz = pripojDatabazi();
    $sql = "INSERT INTO rezervace (id_kurt, jmeno, prijmeni, email, telefon, cas, datum) VALUES ($id_kurt, '$jmeno', '$prijmeni', '$email', $telefon, $cas, '$datum')";
    if(mysqli_query($odkaz, $sql)){
        echo "Records inserted successfully.";
    }else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($odkaz);
    }
    odpojDatabazi($odkaz);
}

function OdeberRezervaci($id_rezervace){
  $odkaz = pripojDatabazi();
    $sql = "DELETE FROM rezervace WHERE id_rezervace='$id_rezervace'";
    if(!mysqli_query($odkaz, $sql)){
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($odkaz);
    }
    odpojDatabazi($odkaz);
}

function KontrolaDat($id_rezervace, $jmeno, $prijmeni, $email, $telefon, $cas, $id_kurt){
  if(strlen($jmeno) < 1){
    echo "ID: ".$id_rezervace." | Pole jméno je prázdné.<br>";
    return false;
  }
  if(strlen($prijmeni) < 1){
    echo "ID: ".$id_rezervace." | Pole příjmení je prázdné.<br>";
    return false;
  }
  if(strlen($email) < 1){
    echo "ID: ".$id_rezervace." | Pole email je prázdné.<br>";
    return false;
  }
  if(strlen($telefon) < 1){
    echo "ID: ".$id_rezervace." | Pole telefon je prázdné.<br>";
    return false;
  }
  if(strlen($cas) < 1){
    echo "ID: ".$id_rezervace." | Pole čas je prázdné.<br>";
    return false;
  }
  if(strlen($id_kurt) < 1){
    echo "ID: ".$id_rezervace." | Pole kurt je prázdné.<br>";
    return false;
  }
  if(!is_numeric($telefon)){
    echo "ID: ".$id_rezervace." | Pole telefon není číslo.<br>";
    return false;
  }
  if(!is_numeric($cas)){
    echo "ID: ".$id_rezervace." | Pole čas není číslo.<br>";
    return false;
  }
  if(!is_numeric($id_kurt)){
    echo "ID: ".$id_rezervace." | Pole kurt není číslo.<br>";
    return false;
  }
  if($telefon < 0){
    echo "ID: ".$id_rezervace." | Pole telefon je menší něž nula.<br>";
    return false;
  }
  if($cas < 0){
    echo "ID: ".$id_rezervace." | Pole čas je menší něž nula.<br>";
    return false;
  }
  if($id_kurt < 0){
    echo "ID: ".$id_rezervace." | Pole kurt je menší něž nula.<br>";
    return false;
  }
  if($cas > 20 || $cas < 8){
    echo "ID: ".$id_rezervace." | Pole čas je mimo interval <8-20>.<br>";
    return false;
  }
  if($id_kurt > 3 || $id_kurt < 0){
    echo "ID: ".$id_rezervace." | Pole kurt je mimo interval <1-3>.<br>";
    return false;
  }
  return true;
}

function UpravRezervaci($id_rezervace, $jmeno, $prijmeni, $email, $telefon, $cas, $id_kurt){
  if(KontrolaDat($id_rezervace, $jmeno, $prijmeni, $email, $telefon, $cas, $id_kurt)){
    $odkaz = pripojDatabazi();
    $sql = "UPDATE rezervace SET jmeno='$jmeno', prijmeni='$prijmeni', email='$email', telefon='$telefon', cas='$cas', id_kurt='$id_kurt' WHERE id_rezervace='$id_rezervace'";
    if(!mysqli_query($odkaz, $sql)){
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($odkaz);
    }
    odpojDatabazi($odkaz);
  }
}

?>
