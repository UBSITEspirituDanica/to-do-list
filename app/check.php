<?php
    if(isset($_POST['id'])){
        require '../connection.php';

        $id = $_POST['id'];

        if(empty($id)){
        echo 'error';
        }else {
            $lists = $conn->prepare("SELECT id, checked FROM lists WHERE id=?");
            $lists->execute([$id]);

            $list = $lists->fetch();
            $uId = $list['id'];
            $checked = $list['checked'];

            $uChecked = $checked ? 0 : 1;

            $res = $conn->query("UPDATE lists SET checked=$uChecked WHERE id=$uId");

            if($res){
                echo $checked;
            }else {
                echo "error";
            }
            $conn = null;
            exit();
        }
    }else {
        header("Location: ../index.php?mess=error");
    }
?>