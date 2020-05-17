<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    //include('connect.php');
    include('config/mysqli.php');
    
    if(isset($_POST['additem'])){
        if (isset($_POST['name'])) {$name = $_POST['name'];}
        if (isset($_POST['token'])) {$token = $_POST['token'];}
        if (isset($_POST['action'])) {$action = $_POST['action'];}
            
        $result = mysqli_query($db,"INSERT INTO `remaskfb`(`name`, `token`,`action`) VALUES ('$name','$token','$action')");
             
        if($result == 'true')
            header("Refresh:0");
                else echo "<h1>error</h1>";
    }

    if(isset($_POST['delete'])){
        $token = $_POST['selectbox2'];
        $query = "DELETE FROM remaskfb WHERE remaskfb.token ='$token'";
        $car = mysqli_query($db, $query);

        header("Refresh:0");
    };
    
?>

<!doctype html>
		<html lang="en">
		<head class="text-center">
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=2, shrink-to-fit=no">
			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="styles/bootstrap.min.css">
    		<meta charset="utf8">
			<link href="styles/signin.css" rel="stylesheet">
			<title></title>
			
			<script type="text/javascript">
            <!--
            function validate_form ()
            {
            	valid = true;
            
                    if ( document.add.name.value == "" && document.add.token.value == "")
                    {
                            alert ( "Нужно заполнить все поля" );
                            valid = false;
                    }
                    return valid;
            }
            //-->
            
            <!-- -->
            function load_data()
            {
                var list = document.getElementById("table").getElementsByTagName("tr");
                
                for (var k = list.length - 1; k >= 0; k--) {
                    var item = list[k];
                    item.parentNode.removeChild(item);
                }
                   
                var s = document.createElement('script');
                s.src = 'loadstat.js';
                document.head.appendChild(s);
            }
            <!-- -->
            </script>
		</head>
	<body class="text-center">
	    
    <div class="form-group">
     <?php echo "<a href='index.php'>Статистика</a> / <a href='rules.php'>Автоправила</a><br>" ?>
    <b style="color:#c8ccd6">Добавить</b>
    <form name="add" method="post" onsubmit="return validate_form ()" >
    <input name="name" type="text" class="form-control" value="" placeholder="Имя">
    <input name="token" type="text" class="form-control" value="" placeholder="Токен"> 
    <!--<select name='action' class='form-control'>
    <option value=HIDE>Скрывать комментарии</option>
    <option value=DELETE>Удалять комментарии</option>
    <option value=NULL>Ничего не делать</option>
    </select>-->
    <input type=submit name='additem' class="btn btn-primary" value="ok">
    </form>
    <b style="color:#c8ccd6">Загрузить</b>
    <?php include 'loadlist.php'?>
    <select id='selectbox3' class='form-control'>
    <option value='active'>Только активные</option>
    <option value='all'>Показывать все</option>
    <option value='active_total'>Тотал по активным</option>
    <option value='all_total'>Тотал по всем</option>
    </select>
    <select id='selectbox1' class='form-control'>
    <option value='today'>За сегодня</option>
    <option value='yesterday'>За вчера</option>
    <option value='lifetime'>За все время</option>
    <option value='last_7d'>За последние 7 дней</option>
    <option value='last_month'>За последний месяц</option>
    </select>
    <input type="button" name="load" onclick = "load_data()" class="btn btn-primary" value="Загрузить"/>
    <form method="POST">
    <input type="submit" name="delete" class="btn btn-danger" value="Удалить"/>
    </form>
    </div>
<table class="table table-dark table-hover" style="font-size: 16px;">
<tbody id="table"></tbody>
</table>
<script src="styles/jquery-2.1.4.min.js"></script>
<script src="styles/bootstrap.min.js"></script>
<div id='message'></div>
</body>
</html>