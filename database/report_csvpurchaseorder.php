<?php
    $type = $_GET['report'];   
    $file_name = '.xls';

    $mapping_filenames = [
        'product_in' => 'Purchase Order'
    ];

    $file_name = $mapping_filenames[$type] . '.xls';

    header("Content-Disposition: attatchment; filename=\"$file_name\"");
    header("Content-Type: application/vnd.ms-excel");

    include('connection.php');

    //pull data from database
    if ($type === 'product_in') {
    
    
        $stmt = $conn->prepare("SELECT * FROM product_in");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $product_in = $stmt->fetchAll();

        //
        $is_headers = true;
        foreach ($product_in as $pi) {
            if ($is_headers) {
                $row = array_keys($pi);
                $is_headers = false;
                echo implode("\t", $row) . "\n";
            }

            array_walk($pi, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '""')) $str = '""' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $pi) . "\n";
        }
    }
