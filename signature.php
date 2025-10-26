<?php
// Anti-scraping and privacy headers
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
$modifiedDate = date('D.d.M.Y', strtotime('-3 hours'));
$modifiedTime = date('@h:i A', strtotime('-3 hours'));

echo "<!--
/***********************************************************
    AUTHOR:             SHETTIMAX
    E-MAIL:             shettimax@yahoo.com
    ORG:                M4XDEV
    LOCATION:           Nigeria
    PRODUCT:            MaxCTF
    FIRST CREATED:      Sat.03.Aug.2020 @07:51 PM
    LAST MODIFIED:      $modifiedDate $modifiedTime By SHETTIMAX
************************************************************/
-->";
?>
