<?php
$title = $mess = $type = '';

if(isset($_SESSION['messger']) && count($_SESSION['messger']) > 0){
    $title = $_SESSION['messger']['title'] ?? '';
    $mess = $_SESSION['messger']['mess'] ?? '';
    $type = $_SESSION['messger']['type'] ?? '';
    unset($_SESSION['messger']);
}
?>
<script>
    const mess = {
        title: '<?php  echo $title;?>',
        mess: '<?php  echo $mess;?>',
        type: '<?php  echo $type;?>'
    };
    if (mess.title.trim() !== '' || mess.mess.trim() !== '' || mess.type.trim() !== '') {
        document.addEventListener("DOMContentLoaded", function () {
            messger(mess);
        }); 
    }else{
        console.log('Không có messger nào!');
    }
</script>