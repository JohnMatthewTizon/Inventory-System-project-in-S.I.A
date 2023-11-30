<?php
    $type = $_GET['report'];   
    $file_name = '.xls';

    $mapping_filenames = [
        'product' => 'Product Report'
    ];

    $file_name = $mapping_filenames[$type] . '.xls';

    header("Content-Disposition: attatchment; filename=\"$file_name\"");
    header("Content-Type: application/vnd.ms-excel");

    include('connection.php');

    //pull data from database
    if ($type === 'product') {
    
    
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $productdb = $stmt->fetchAll();

        //
        $is_headers = true;
        foreach ($productdb as $product) {
            if ($is_headers) {
                $row = array_keys($product);
                $is_headers = false;
                echo implode("\t", $row) . "\n";
            }

            array_walk($product, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '""')) $str = '""' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $product) . "\n";
        }
    }
