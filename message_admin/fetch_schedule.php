<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

//ob_start();
$schQuery    = $db->query("SELECT * FROM `scheduled_messages` ORDER BY `id` DESC");

while($schData = mysqli_fetch_array($schQuery)):
$msgArray = json_decode($schData['message'], true);
$recipientArray = json_decode($schData['recipients'], true); 
foreach($recipientArray as $value=>$key){
    echo $key['Recipient_name'];
}
?>
<tr>
<input type="hidden" name="" value="<?=base64_encode($schData['id'])?>">
<td class="text-warning"><div class="btn-group dropend">
  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    View recipients.
  </button>
  <ul class="dropdown-menu" style="max-width: 100%;">
    <?php foreach($recipientArray as $value=>$key) :?>
        <li><?=$key['Recipient_name'].' - '.$key['Phone_Number'];?></li>
    <?php endforeach;?>
  </ul>
</div>
</td>
<td><?=cutstring($msgArray['Subject'].' - '.$msgArray['Message'], 90)?></td>
<td><?=$schData['send_time']?></td>
</tr>
<?php endwhile;

//echo ob_get_clean();
?>