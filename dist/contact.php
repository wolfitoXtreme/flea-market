<?php

    # files
    require "includes/functions.inc.php";

    #connection
    $connection =  mysql_connect($host, $user, $password);
    mysql_set_charset('utf8',$connection); 
    
    if (!$connection) {
        die('Could not connect: ' . mysql_error());
    }
    
    mysql_select_db($dataBase, $connection);

    #item
    $itemQuery = mysql_query("SELECT * FROM fleaMarket WHERE ID = ".$_GET["ID"]);
    $numRows = mysql_num_rows($itemQuery);

    #close connection
    mysql_close($connection);


?>

<?

    $row = mysql_fetch_array($itemQuery);

?>


<div id="contactForm">

    <p>Estas interesado en comprar<br>
    <strong class="buyItem"><?=$row['name']?></strong>
    <strong class="price"><?=$row['price']?></strong>
    </p>

<?
    $files = $row['images'];
    $files = explode("/",$files);
    $coverImage = $files[0];

?>

    <div class="image">
        <figure>
        <span title="<?=$row['name']?>"><img src="img/<?=$coverImage?>.jpg" width="" height="" alt="<?=$row['name']?>"></span>
        </figure>
    </div>

    <div>

<?

if($row['link'] != "0") {
?>
        <p>
        Puedes, contactarme para comprarlo en <strong>App Wallapop</strong><br>
        <a href="http://es.wallapop.com<?=$row['link']?>" class="submitButton contact" target="_blank"><span>contactar</span></a>

        </p>
<?
}
?>
        <p>
<?
if($row['link'] != "0") {
?>
    Si prefieres puedes enviarme un email:<br>
<?
}
else {
?>
    Puedes enviarme un email:<br>
<?
}
?>
        <strong><span class="email">mainwolfito{at}yahoo.com</span></strong><br> 
        o llamarme al <br>
        <strong>(+34) 626 14 12 16</strong>
        </p>
        
        <p>
        gracias por tu interés, CESAR
        </p>

    </div>

    <a class="closeMessage">close</a>

</div>