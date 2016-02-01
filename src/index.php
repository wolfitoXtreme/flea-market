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
    $sql = "SELECT * FROM fleaMarket LIMIT $offset, $rowsperpage";
    $result = mysql_query($sql, $connection);

    #close connection
    mysql_close($connection);

// /******  build the pagination links ******/
// // range of num links to show
// $range = 3;

// // if not on page 1, don't show back links
// if ($currentpage > 1) {
//    // show << link to go back to page 1
//    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
//    // get previous page num
//    $prevpage = $currentpage - 1;
//    // show < link to go back to 1 page
//    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
// } // end if 

// // loop to show links to range of pages around current page
// for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
//    // if it's a valid page number...
//    if (($x > 0) && ($x <= $totalpages)) {
//       // if we're on current page...
//       if ($x == $currentpage) {
//          // 'highlight' it but don't make a link
//          echo " [<b>$x</b>] ";
//       // if not current page...
//       } else {
//          // make it a link
//          echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
//       } // end else
//    } // end if 
// } // end for
                 
// // if not on last page, show forward and last page links        
// if ($currentpage != $totalpages) {
//    // get next page
//    $nextpage = $currentpage + 1;
//     // echo forward link for next page 
//    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
//    // echo forward link for lastpage
//    echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
// } // end if
// /****** end build pagination links ******/
   
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

                        <a href="#" data-images="<?=$row['images']?>" title="<?=$row['name']?>"><img src="img/<?=$coverImage?>.jpg" width="" height="" alt=""></a>
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
                    <form method="post" action="/flea-market/contact.php" class="itemForm">
                        <fieldset>
                        <input type="hidden" name="article" value="<?=$row['name']?>">
                        <input type="hidden" name="article" value="<?=$row['link']?>">
                        <button type="submit" name="comprar" value="comprar" class="submitButton contact"><span>contactar</span></button>
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

                <p class="viewMore">
                    <a href="test_page01.htm" class="viewMore_link">ver más</a>
                </p>
                
            
            </main>
            <!--====== MAIN ======-->


<?
require "includes/footer.inc.php";
?>