<?php
$title = $mess = $type = '';

if(isset($_SESSION['messager']) && count($_SESSION['messager']) > 0){
    $title = $_SESSION['messager']['title'] ?? '';
    $mess = $_SESSION['messager']['mess'] ?? '';
    $type = $_SESSION['messager']['type'] ?? '';
    unset($_SESSION['messager']);
}
?>
<script>
    const mess = {
        title: '<?= $title;?>',
        mess: '<?= $mess;?>',
        type: '<?= $type;?>'
    };
    if (mess.title.trim() !== '' || mess.mess.trim() !== '' || mess.type.trim() !== '') {
        document.addEventListener("DOMContentLoaded", function () {
            messager(mess);
        }); 
    }
</script>