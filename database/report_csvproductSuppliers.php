<?php
    $type = $_GET['report'];   
    $file_name = '.xls';

    $mapping_filenames = [
        'order_product_history' => 'Delivery Report'
    ];

    $file_name = $mapping_filenames[$type] . '.xls';

    header("Content-Disposition: attatchment; filename=\"$file_name\"");
    header("Content-Type: application/vnd.ms-excel");

    include('connection.php');

    //pull data from database
    if ($type === 'order_product_history') {
    
    
        $stmt = $conn->prepare("SELECT * FROM order_product_history");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $order_product_history = $stmt->fetchAll();

        //
        $is_headers = true;
        foreach ($order_product_history as $oph) {
            if ($is_headers) {
                $row = array_keys($oph);
                $is_headers = false;
                echo implode("\t", $row) . "\n";
            }

            array_walk($oph, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '""')) $str = '""' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $oph) . "\n";
        }
    }
