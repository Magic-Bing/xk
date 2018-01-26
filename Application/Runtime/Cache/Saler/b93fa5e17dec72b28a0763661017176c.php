<?php if (!defined('THINK_PATH')) exit();?><table class="fl wm100" style="color: #999999;text-align: center;" id="content-tab">
    <?php if(count($user_xf) >= 1): if(is_array($user_xf)): foreach($user_xf as $k=>$vo): ?><tr data-id="<?php echo ($vo["id"]); ?>">
                <td align="left" class="wm40" style="padding-left: 15px">
                    <p><?php echo ($vo["customer_name"]); ?></p>
                    <p><?php echo rsa_decode($vo['customer_phone'],getChoosekey());?></p>
                </td>
                <td class="wm25"><?php if(($vo["oid"] != null)): ?><span class="xf-status ydl">已登录</span><?php else: ?><span class="xf-status wdl">未登录</span><?php endif; ?></td>
                <td class="wm20"><?php if(($vo["rid"] != null) AND ($vo["oid"] != null)): ?><span class="xf-status yxf">已选房</span><?php else: ?><span class="xf-status wxf">未选房</span><?php endif; ?></td>
                <td class="wm15"><span class="call-phone" data-num="<?php echo rsa_decode($vo['customer_phone'],getChoosekey());?>"><i class="fa fa-phone"></i></span></td>
            </tr><?php endforeach; endif; ?>
        <?php else: ?>
        <tr>
            <td colspan="3" align="center">暂时没有数据...</td>
        </tr><?php endif; ?>
</table>
</div>