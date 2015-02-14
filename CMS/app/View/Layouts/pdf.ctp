<?php
    header('Content-Disposition: attachment; filename="downloaded.pdf"');
    echo "Table QRcodes";
    echo $content_for_layout;
?>