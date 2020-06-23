<?php
extract($_GET);
require("connection.php");

if(isset($state)) {
    
    try{
        switch ($state) {
            case 'e':
                $sql="select count(sid) from staff;";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;
            
            case 'c':
                $sql="select count(cid) from customer;";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;
    
            case 'o':
                $sql="select count(oid) from ordering;";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;
    
            case 't':
                $sql="select sum(total) from ordering;";
                $r = $db->query($sql);
                foreach($r as $row){
                    $sum=number_format($row['0'], 3);
                    echo $sum.'  BD';
                }
                break;

            case 'cooke':
                $sql="select count(total) from ordering where state='C';";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;

            case 'deliver':
                $sql="select count(total) from ordering where state='D';";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;

            case 'done':
                $sql="select count(total) from ordering where state='F';";
                $r = $db->query($sql);
                foreach($r as $row){
                    echo $row['0'];
                }
                break;
        }
    }

    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
}
?>