<?php if (!defined('THINK_PATH')) exit();?>﻿<?php if(is_array($floors)): $floors_k = 0; $__LIST__ = $floors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$floors_vo): $mod = ($floors_k % 2 );++$floors_k;?><tr>
		<td class="saler-project-view-content-rooms-floor" data-floor-id="<?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):"1"); ?>">
			<?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):"1"); ?>F
		</td>
		<td class="saler-project-view-content-rooms-room" data-floor-id="<?php echo ((isset($floors_vo["floor"]) && ($floors_vo["floor"] !== ""))?($floors_vo["floor"]):"1"); ?>">
			<div class="saler-project-view-content-rooms-list">
				<ul class="clearfix">
				
					<?php if(is_array($rooms[$floors_vo['floor']])): $rooms_k = 0; $__LIST__ = $rooms[$floors_vo['floor']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rooms_vo): $mod = ($rooms_k % 2 );++$rooms_k;?><li class="fl wm25">
							<a href="<?php echo U('room/index', array('id' => $rooms_vo['id'],'hid' => $search_hd_id));?>" class="saler-project-view-content-rooms-room-a">
								<?php if(!empty($rooms_vo['djcount'])): ?><i class="saler-project-hot"></i><?php endif; ?>
								<div class="saler-project-view-content-rooms-room-box <?php if($rooms_vo['is_xf'] == 1): ?>saler-project-view-content-rooms-room-box-selected<?php endif; ?>">
									<div class="saler-project-view-content-rooms-room-name">
										<?php echo ($rooms_vo['room']); ?>
									</div>
									<div class="saler-project-view-content-rooms-room-area">
										<?php echo ((isset($rooms_vo['area']) && ($rooms_vo['area'] !== ""))?($rooms_vo['area']):'0'); ?>㎡
									</div>
									<div class="saler-project-view-content-rooms-room-cost">
										¥<?php echo (intval((isset($rooms_vo['total']) && ($rooms_vo['total'] !== ""))?($rooms_vo['total']):'0')); ?>
									</div>
								</div>
							</a>
								
							<div data-room-id="<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" class="saler-project-view-content-rooms-room-box-shadow js-saler-project-view-content-rooms-room-box-shadow">
								<div class="saler-project-view-content-rooms-room-box-shadow-info">
									<span class="saler-project-view-content-rooms-room-box-shadow-info-select">
										<input class="saler-project-view-content-rooms-room-select js-saler-project-view-content-rooms-room-box-shadow saler-project-view-content-rooms-room-select-<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" data-room-id="<?php echo ((isset($rooms_vo['id']) && ($rooms_vo['id'] !== ""))?($rooms_vo['id']):'1'); ?>" type="checkbox" value="1">
									</span>
								</div>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>

				</ul>
			</div>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>