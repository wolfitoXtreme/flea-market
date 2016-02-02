<?php

    #styles
    $_styles = ""
        ."<link rel=\"stylesheet\" type=\"text/css\" href=\"/flea-market/css/jquery.fancybox-1.3.4.css\" media=\"screen\">\n"
        ."<link rel=\"stylesheet\" type=\"text/css\" href=\"/flea-market/css/fleaMarket.css\" media=\"screen\">\n";
    
    #scripts
    $_scripts = ""
        ."<script type=\"text/javascript\" src=\"/flea-market/js/flea-Market.js\"></script>\n";

    # files
    require "includes/session.inc.php";
    require "includes/functions.inc.php";
    require "includes/header.inc.php";
    
    #connection
    $connection =  mysql_connect($host, $user, $password);
    mysql_set_charset('utf8',$connection); 
    
    if (!$connection) {
        die('Could not connect: ' . mysql_error());
    }
    
    mysql_select_db($dataBase, $connection);

    #items
    $itemsQuery = mysql_query("SELECT * FROM fleaMarket");
    $numRows = mysql_num_rows($itemsQuery);

    // number of rows to show per page
    $rowsperpage = 10;

    // find out total pages
    $totalpages = ceil($numRows / $rowsperpage);

    // get the current page or set a default
    if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
        // cast var as int
        $currentpage = (int) $_GET['currentpage'];
    } else {
        // default page num
        $currentpage = 1;
    }

    // current page is greater than total pages
    if ($currentpage > $totalpages) {
        // set current page to last page
        $currentpage = $totalpages;
    }
    
    // current page is less than first page...
    if ($currentpage < 1) {
        // set current page to first page
        $currentpage = 1;
    }

    // the offset of the list, based on current page 
    $offset = ($currentpage - 1) * $rowsperpage;

    // get the info from the db 
    $sql = "SELECT * FROM fleaMarket ORDER BY ID desc LIMIT $offset, $rowsperpage";
    // $sql = "SELECT * FROM (SELECT * FROM fleaMarket ORDER BY ID LIMIT $offset, $rowsperpage) AS tmp_table ORDER BY sold";
    $result = mysql_query($sql, $connection);

    #close connection
    mysql_close($connection);

    // net page
    $nextpage = $currentpage + 1;


?>
     
            <!--====== MAIN ======-->        
            <main id="main">

                <!-- listing -->
                <ul class="row sameHeightList">
<?
while ($row = mysql_fetch_assoc($result)) {
?>

                <!-- item -->
                <li class="item<?=($row['sold'] == true ? ' sold' : '')?>">

                    <div class="image">
                        <figure>
<?
    $files = $row['images'];
    $files = explode("/",$files);
    $coverImage = $files[0];

?>

                        <a href="#" data-images="<?=$row['images']?>" title="<?=$row['name']?>"><img src="img/<?=$coverImage?>.jpg" width="" height="" alt="<?=$row['name']?>"></a>
                        </figure>
                    </div>

                    <div class="title">
                
                        <h2>
                        <?=$row['name']?>
                        </h2>

<?
    if($row['brand'] != '') {
?>
                        <p class="brand"><strong><?=$row['brand']?></strong></p>

<?
    }
?>                   

                    </div>
                    
                    <div class="description">

                        <ul class="data">
                        <li>Estado: <?=$row['shape']?></li>
<?
    if($row['age'] != '') {
?>
                        <li>Antiguedad: <?=$row['age']?></li>
<?
    }
?> 
                        </ul>

                        <p>
                        <?=$row['description']?>
                        </p>

                    </div>


                    <div class="price">
                        
                        <p>
                        <strong>€ <?=$row['price']?></strong>
                        </p>
                        
                    </div>
                
                    <!-- comprar item -->
                    <form method="get" action="/flea-market/contact.php" class="itemForm">
                        <fieldset>
                        <input type="hidden" name="ID" value="<?=$row['ID']?>">
                        <button type="submit" name="comprar" value="comprar" class="submitButton contact" <?=($row['sold'] == true ? ' disabled' : '')?>><span>contactar</span></button>
                        </fieldset>
                    </form>
                    <!-- comprar item -->
        
                    
                </li>
                <!-- item -->

<?
}


?>
                </ul>
                <!-- listing -->

<?
if ($currentpage != $totalpages) {
?>
                <p class="viewMore">
                    <a href="/flea-market/?currentpage=<?=$nextpage?>" class="viewMore_link">ver más</a>
                </p>           
<?
}
?>          
            
            </main>
            <!--====== MAIN ======-->


<?
require "includes/footer.inc.php";
?>