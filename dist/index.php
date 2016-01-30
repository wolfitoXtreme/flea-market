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
    
    
    $abs_path = getcwd();
    //echo $abs_path;
   
?>
     
 content

<!--====== FOOTER ======-->
<!--====== FOOTER ======-->


<?
require "includes/footer.inc.php";
?>