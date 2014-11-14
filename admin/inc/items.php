	<div class="items"><?
		foreach ($arAllMedia as $arMedia):
		?><div class="item">
			<div class="info">
				<div class="author">
					<div class="left">
						<a href="<?=$arMedia['USER']['PROFILE_URL'];?>" title="<?=$arMedia['USER']['FULL_NAME'];?>">
							<img class="profile" src="<?=$arMedia['USER']['PROFILE_PICTURE'];?>" alt="<?=$arMedia['USER']['USERNAME'];?>">
						</a>
					</div>
					<div class="left">
						<a class="uline" href="<?=$arMedia['USER']['PROFILE_URL'];?>" title="<?=($arMedia['USER']['FULL_NAME'] ? $arMedia['USER']['FULL_NAME'] : $arMedia['USER']['USERNAME']);?>">
							<?=$arMedia['USER']['USERNAME'];?>
						</a>
						<div class="location">
							<div class="cover">
								<img src="/images/cover.png">
							</div>
							<div class="location_a_wrapper">
								<a class="uline" href="<?=$arMedia['LOCATION']['LINK'];?>" title="<?=$arMedia['LOCATION']['NAME'];?>">
									<?=$arMedia['LOCATION']['NAME'];?>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="time" title="<?=date('d.m.Y H:i:s', $arMedia['MEDIA']['CREATED_TIME']);?>">
						<?=date('H:i', $arMedia['MEDIA']['CREATED_TIME']);?>
					</div>
					<div class="clear"></div>
					<div class="stats">
						<div class="comments"><?=$arMedia['MEDIA']['COMMENTS_COUNT']?></div>
						<div class="likes"><?=$arMedia['MEDIA']['LIKES_COUNT']?></div>
					</div>
				</div>
			</div>
			<div class="media">
				<a href="<?=$arMedia['MEDIA']['LINK'];?>" title="<?=$arMedia['MEDIA']['CAPTION'];?>">
					<img src="<?=$arMedia['MEDIA']['URL_LOW']?>">
				</a>
			</div>
		</div><?
		endforeach;
		?><div class="clear"></div>
	</div>