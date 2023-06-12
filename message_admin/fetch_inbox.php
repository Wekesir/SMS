<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

ob_start();
$msgQuery    = $db->query("SELECT * FROM `messages` ORDER BY `id` DESC");

while($msgData = mysqli_fetch_array($msgQuery)):?>
<tr>
<input type="hidden" name="" value="<?=base64_encode($msgData['id'])?>">
<td class="text-warning" title="<?=$msgData['first_name']?>"><b><?=cutstring($msgData['first_name'], 10)?></b></td>
<td class="text-info"><?=$msgData['phonenumber']?></td>
<td><?=cutstring($msgData['message'], 98)?></td</tr>
<?php endwhile;

echo ob_get_clean();
?>