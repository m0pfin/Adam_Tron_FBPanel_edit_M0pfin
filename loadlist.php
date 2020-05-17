<?php

include('config/mysqli.php');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    $select = mysqli_query($db,'SELECT * FROM `remaskfb`');
     
    echo "<form method='post'><select id='selectbox2' name='selectbox2' class='form-control' style='text-align:center;'></form>";//выводим открывающийся тэг
    if(mysqli_num_rows($select)>0)
    {
        echo '<option value=all>Загрузить все</option>';
        while($resource = mysqli_fetch_array($select, MYSQLI_BOTH)){
            printf("<option value='%s'>%s</option>",$resource["token"],$resource["name"]);
        }
    }
    echo "</select>";//выводим закрывающий тэг
?>