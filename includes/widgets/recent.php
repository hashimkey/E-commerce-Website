

<h3 class="text-center">popular Items</h3>


<?php


$transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5");
$results = array();
while ($row = mysqli_fetch_assoc($transQ)) {
  $results[] = $row;

}
$row_count = $transQ->num_rows;
$used_ids = array();
 for ($i=0; $i<$row_count; $i++) {
   $json_items = $results[$i]['items'];
   $items = json_decode($json_items,true);
   foreach ($items as $item) {
     if (!in_array($item['id'],$used_ids)) {
       $used_ids[] = $item['id'];
     }
   }
 }
 ?>
 <div class="" id="recent_widget">
   <table class="table table-condensed">
     <?php foreach($used_ids as $id):
         $productQ = $db->query("SELECT id,title,image FROM products WHERE  id = '{$id}' ");
         //$productQ = $db->query("SELECT id,title FROM products WHERE id = '{$id}'");﻿
         $product = mysqli_fetch_assoc($productQ);
       ?>
       <tr>
         <td>

            <?= substr($product['title'],0,15);?>
         </td>
         <td><img src="<?=$product['image'];?>" alt=" " height="75" width="75"></td>
         <td>
          <a href="#" class="text-primary" onclick="detailsmodal('<?= $id;?>')">View</a>
         </td>
       </tr>



     <?php endforeach; ?>

   </table>

 </div>
