<?php
    $username = 'oracle';
    $password = 'oracle';
    $connection_string = 'localhost/XE';

    //Connect to an Oracle database
    $connection = oci_connect(
        $username,
        $password,
        $connection_string
    );
?>
    
