<?php
    $type = $_GET['report'];   
    $file_name = '.xls';

    $mapping_filenames = [
        'productSuppliers' => 'Delivery Report'
    ];

    $file_name = $mapping_filenames[$type] . '.xls';

    header("Content-Disposition: attatchment; filename=\"$file_name\"");
    header("Content-Type: application/vnd.ms-excel");

    include('connection.php');

    //pull data from database
    if ($type === 'productSuppliers') {
    
    
        $stmt = $conn->prepare("SELECT * FROM productsuppliers");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $productsuppliers = $stmt->fetchAll();

        //
        $is_headers = true;
        foreach ($productsuppliers as $productsupp) {
            if ($is_headers) {
                $row = array_keys($productsupp);
                $is_headers = false;
                echo implode("\t", $row) . "\n";
            }

            array_walk($productsupp, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '""')) $str = '""' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $productsupp) . "\n";
        }
    }
