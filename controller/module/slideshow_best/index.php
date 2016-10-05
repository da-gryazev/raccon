<?
$catalog = strong::loadModel("catalog");
if($data['idcategory'])$dataproduct = $catalog->getProductMini(array('category'=>$data['idcategory']));else $dataproduct = $data;
if(!$dataproduct)echo "<div class='sixteen wide column'>По данному запросу ничего не найдено.</div>";
$i=0;

if($data['idcategory']!=10):
		if($_GET['q']):?><div class='sixteen wide column'>Результаты по запросы: <?=$_GET['q'];?></div><? endif;
			foreach ($dataproduct as $key => $value):
			$i++?>					

							<div class="five wide column">
								<div class="sh-col-image">
									<div style="margin-top:10%;">
									<a class="nonelink" href="?p=catalog&idproduct=<?=$value['id']?>"><img src='<?=GLife_src?>image/<?=$value['image']['info']['src']?>' alt="<?=$value['image']['info']['alt']?>" height="115px"></div>
								</div>
								<div class="sh-col"><?=$value['title']?></a></div>
							<div class="available-text">В наличии</div>
								<div class="ui grid">
									<div class="seven wide column"><span class="pricenumber"><span style="margin-right:5px;"><?=round($value['price'])?></span></span></div>
									<div class="column">
										<?if($value['basket']['idproduct']!=$value['id']):?><button class="buttonbasket" id="button<?=$value['id']?>" onClick="ajaxRequest('addbasket','<?=$value['id']?>',1)">Купить</button><?else:?>
										<button class="inbasketbutton" id="button<?=$value['id']?>" ><a href='?p=profile' class='nonelink'>В корзину</a></button><?endif;?>
									</div>
								</div> 
							</div>

						<?endforeach;?>
						<?for($i;$i<3;$i++)echo "<div class='column'></div>";?>
						<?else:?>
							<?strong::$template->includeModule("podramniki");?>
						<?endif;?>