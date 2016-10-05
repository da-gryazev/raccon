<?php
  
     
 
  
  function popup($text,$locat){
  ?>
  <div id="parent_popup">
  <div id="popup">
    <p style="cursor: pointer;text-align:left;margin:-10px;width:30px;height:30px;" onclick="document.getElementById('parent_popup').style.display='none';location.href='<?php echo $locat;?>'"><img src='img/exit.png'></p>
    <p><?echo $text;?></p>
  </div>
</div>
  <?
  }
?>
 