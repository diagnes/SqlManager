<?php

function initConnection($db = 'DspSQL'){
    try{
        $conn = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', 'root', 'epharma');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conn;
    }catch(PDOException $ex){
        echo json_encode(array('success'=>false, 'message' => $ex->getMessage()));
        return false;
    }
}

function initDatabaseName($conn){
    try{
        $request = "SHOW DATABASES";
        $element = array();
        $data= array();

        $conn->prepare($request);
        $query = $conn->query($request);
        foreach  ($query as $row) {
            foreach($row as $key => $value){
                if (!is_integer($key)){
                    array_push($data,$value);
                }
            }
        }
        return array('success'=>true, 'data' => $data);
    }catch (Exception $e){
        return array('success'=>false,'data' => $e->getMessage());
    }

}

function initTableName($conn, $db){
    try{
        $request = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='". $db ."'";
        $data= array();

        $conn->prepare($request);
        $query = $conn->query($request);
        foreach  ($query as $row) {
            foreach($row as $key => $value){
                if (!is_integer($key)){
                    array_push($data,$value);
                }
            }
        }
        return array('success'=>true, 'data' => $data);
    }catch (Exception $e){
        return array('success'=>false, 'data' => $e->getMessage());
    }
}

function initHistorique(){
    try{
        $file = 'historique.txt';
        $current = file_get_contents($file);
        $storys = explode('\n', $current);
        $datas = array();
        foreach ($storys as $story){
            $element = explode(';', $story);
            $data['label'] = (isset($element[0])) ? $element[0] : '';
            $data['bdd'] = (isset($element[1])) ? $element[1] : '';
            $data['request'] = (isset($element[2])) ? $element[2] : '';
            array_push($datas,$data);
        }
        return array('success'=>true,'data' => $datas);
    }catch (Exception $e){
        return array('success'=>false,'data' => $e->getMessage());
    }
}

$conn = initConnection();
if ($conn){
    $data = array();
    $data['Db'] = initDatabaseName($conn);
    $data['Historique'] = initHistorique($conn);
    if (isset($_POST['bdd']) && $_POST['bdd']){
        $data['Table'] = initTableName($conn, $_POST['bdd']);
    }
    echo json_encode($data);
}
?>