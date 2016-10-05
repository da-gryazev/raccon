<?
//index.php - главный файл модуля который инклудиться
$catalog = strong::loadModel("catalog");
if(!$data['idcategory'])die;
$parametrs = $catalog->getParametrs(0,$data['idcategory']);

?>
<div class="boxradius">

				<? for($i=0;$i<count($parametrs);$i++):?>
				<?if(!$parametrs[$i]['filter'])continue;?>
					 <?php switch($parametrs[$i]['type']):
						 case '1':?>
							<?=$parametrs[$i]['title']?>: <input type="text" class="priceform" id="<?=strong::translitlang($parametrs[$i]['title'])?>" value="от">
						<?php break; ?>

						<?php case '2':?>
							<div class="select">
								<?=$parametrs[$i]['title']?>: <input type="text" id="<?=strong::translitlang($parametrs[$i]['title'])?>one" class="priceform" value="от"> - <input type="text" id="<?=strong::translitlang($parametrs[$i]['title'])?>two" class="priceform" value="до">
							</div>
						<?php break; ?>

						<?php case '3':?>
						<?if(count($parametrs[$i]['value'])):?>
							<?=$parametrs[$i]['title']?>
							<select class="select select-background" id="<?=$parametrs[$i]['id']?>">
							<option>...</option>
								<?for($k=0;$k<count($parametrs[$i]['value']);$k++):?>
									<option   value="<?=$parametrs[$i]['value'][$k]['value']?>"><?=$parametrs[$i]['value'][$k]['value']?></option>
								<?endfor;?>
							</select>
						<?endif;?>
						<?php break; ?>
						<?php default:?>

					<?php endswitch;?>
				<?php endfor;?>

			<div style="text-align:right;"><button class="filter-button" onclick="getParametrs();">искать</button></div>

</div>