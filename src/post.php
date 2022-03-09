<?php
session_start();
//session_destroy();
if(!isset( $_SESSION['todo'])){
    $_SESSION['todo'] = array();
}
if(!isset( $_SESSION['complete'])){
    $_SESSION['complete'] = array();
}
class todo {
    public $task;
    function __construct($task)
    {
        $this->task = $task;
    }
    function add() {
        array_push( $_SESSION['todo'] ,$this->task);
    }
    function edit() {
        array_splice($_SESSION['todo'],$_POST['edit'],1,$this->task);
    }
    function del(){
        array_splice($_SESSION['todo'],$this->task,1);
    }
    function change() {
        array_splice($_SESSION['todo'],$_POST['delete'],1);
        array_push($_SESSION['complete'] ,$_POST['complete']);
    }
    function unchange() {
        array_splice($_SESSION['complete'],$_POST['delete'],1);
        array_push($_SESSION['todo'] ,$_POST['todo']);
    }
}
?>
<?php
if(isset($_POST['action']) && $_POST['action']=='todo'){
    $obj = new todo($_POST['todo']);
    $obj->add();
    echo json_encode($_SESSION['todo']);
 
}
if(isset($_POST['action']) && $_POST['action']=='edit'){
    $obj = new todo($_POST['u_value']);
    $obj->edit();
    echo json_encode($_SESSION['todo']);
}
if(isset($_POST['action']) && $_POST['action']=='delete'){
    $obj = new todo($_POST['delete']);
    $obj->del();
    echo json_encode($_SESSION['todo']);
}
if(isset($_POST['action']) && $_POST['action']=='check'){
    $obj = new todo($_POST['complete']);
    $obj->change();
       echo json_encode($_SESSION['complete']);
}

?>