<?php
function initConnection($db = 'DspSQL'){
    try{
        $conn = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', 'root', 'epharma');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conn;
    }catch(PDOException $ex){
        echo json_encode(array('success'=>false, 'message' => $ex->getMessage()));
    }
}

function writeInStory($request){
    $file = 'historique.txt';
    $current = $request.'\n';
    if (file_exists($file)){
        $current = file_get_contents($file);
        $current = $request.';'.$_POST['bdd'].';'.$_POST['request'].'\n'.$current;
    }
    file_put_contents($file, $current);
}

function makeRequest($request, $conn){
    try{
        $element = array();
        $data= array();

        $conn->prepare($request);
        $query = $conn->query($request);
        foreach  ($query as $row) {
            foreach($row as $key => $value){
                if (!is_integer($key)){
                    $element[$key] = $value;
                }
            }
            array_push($data,$element);
        }
        writeInStory($request);
        echo json_encode(array('success'=>true, 'data' => $data));
    }catch (Exception $e){
        echo json_encode(array('success'=>false, 'data' => $e->getMessage()));
    }
}

try{
    $conn = (isset($_POST['bdd'])) ? initConnection($_POST['bdd']) : initConnection();
}catch (Exception $e){
    echo json_encode(array('success'=>false, 'data' => $e->getMessage()));
    return false;
}

if (!isset($_POST['request'])){
    echo json_encode(array('success'=>false, 'data' => "Aucune requete n'a été émise"));
}else{
    makeRequest($_POST['request'], $conn);
}

?>