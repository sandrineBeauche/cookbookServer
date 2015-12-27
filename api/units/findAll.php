<?php
    require_once '../../bootstrap.php';
    
    $query = unitQuery::create()
                ->select(array('id', 'name'))
                ->orderByName()
                ->find();

    $data = $query->getData();
 
    echo json_encode($data);
?>
    
