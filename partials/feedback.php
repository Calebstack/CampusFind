<?php
    if(isset($_SESSION['errormsg'])){
?>
      <div class="alert alert-danger"><?php echo $_SESSION['errormsg'];  unset($_SESSION['errormsg']);?></div>
<?php
    }
?>
 <?php
 if(isset($_SESSION['feedback'])){
 ?>
<div class="alert alert-success"><?php echo $_SESSION['feedback'];  unset($_SESSION['feedback']);?></div>
<?php
}
?>