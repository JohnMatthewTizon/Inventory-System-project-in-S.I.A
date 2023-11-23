<?php
    $type = $_GET['report'];   
    $file_name = '.xls';

    $mapping_filenames = [
        'supplier' => 'Supplier Report'
    ];

    $file_name = $mapping_filenames[$type] . '.xls';

    header("Content-Disposition: attatchment; filename=\"$file_name\"");
    header("Content-Type: application/vnd.ms-excel");

    include('connection.php');

    //pull data from database
    if ($type === 'supplier') {
    
    
        $stmt = $conn->prepare("SELECT * FROM suppliers");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $suppliers = $stmt->fetchAll();

        //
        $is_headers = true;
        foreach ($suppliers as $supplier) {
            if ($is_headers) {
                $row = array_keys($supplier);
                $is_headers = false;
                echo implode("\t", $row) . "\n";
            }

            array_walk($supplier, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '""')) $str = '""' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $supplier) . "\n";
        }
    }
