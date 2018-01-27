<?php if (!defined('THINK_PATH')) exit();?><table id="sample-table-choose" class="table table-striped table-bordered table-hover dataTable">
    <thead>
    <tr>
        <th class="center hidden-480" style="min-width: 20px">
            序号
        </th>
        <th>客户姓名</th>
        <th>
            <i class="icon-phone bigger-110 hidden-480"></i>
            客户手机
        </th>
        <th>身份证号码</th>
        <th>诚意金编号</th>
        <th>置业顾问</th>
        <th>分组</th>
        <th>入场序号</th>
        <th>生成时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        <?php if($count > 0): if(is_array($res)): foreach($res as $k=>$vo): ?><tr class="user-tr" data-yp="<?php echo ($vo["ywyphone"]); ?>" money="<?php echo ($vo["money"]); ?>" data-id="<?php echo ($vo["id"]); ?>"  data-is-admission="<?php echo ($vo["is_admission"]); ?>" data-bid="<?php echo ($vo["batch_id"]); ?>">
                    <td class="center"><?php echo ($pages*$page_num+$k+1); ?></td>
                    <td><?php echo ($vo["customer_name"]); ?></td>
                    <td><?php echo rsa_decode($vo['customer_phone'],getChoosekey());?></td>
                    <td><?php echo rsa_decode($vo['cardno'],getChoosekey());?></td>
                    <td><?php echo ($vo["cyjno"]); ?></td>
                    <td><?php echo ($vo["ywy"]); ?></td>
                    <td>第<?php echo ($vo["group"]); ?>组</td>
                    <td><?php echo ($vo["no"]); ?></td>
                    <td><?php echo date('Y-m-d h:i:s',$vo['createdtime']);?></td>
                    <td class="center">
                        <?php if($vo["is_admission"] == 0): ?><span class="sign-check" data-id="<?php echo ($vo["id"]); ?>" title="入场">✔</span>
                            <?php else: ?>
                            <span class="sign-cancel" data-id="<?php echo ($vo["id"]); ?>" title="取消"><i class="icon-undo"></i></span><?php endif; ?>
                    </td>

                </tr><?php endforeach; endif; ?>
            <?php else: ?>
            <tr>
                <td colspan="11" class="center">暂时没有数据...</td>
            </tr><?php endif; ?>
    <tr>
        <td colspan="11">
            <button class="btn btn-xs btn-primary" style="float: right" id="check_user1">
                <i class="icon-cloud-download bigger-110"></i>
                <?php if($count > 0): ?><span class="bigger-110 no-text-shadow" id="check-excel">导出客户数据</span><?php endif; ?>
            </button>
        </td>
    </tr>
    </tbody>

</table>

<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="sample-table-2_info">
            第 <input id="new_page" type="tel" value="<?php echo ($page); ?>" style="width:30px" class="tzpage"> 页/ <span id="all_page"><?php echo ($all_page); ?></span>
            页，每页<input
                id="new_rows" type="tel" value="<?php echo ($page_num); ?>" style="width:30px" class="tzrows"> 条/共 <span id="all_count"><?php echo ($count); ?></span> 条
        </div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_bootstrap">
            <ul class="pagination" id="not-sign">
                <?php if($all_page > 1 ): if($page > 1 ): ?><li><a href="#" style="color: #ffb751">«</a></li><?php endif; ?>

                <?php $__FOR_START_10532__=1;$__FOR_END_10532__=$all_page+1;for($i=$__FOR_START_10532__;$i < $__FOR_END_10532__;$i+=1){ if($i == $page ): ?><li><a href="#" style="background-color: #ffb751;color: #FFF"><?php echo ($i); ?></a></li>
                    <?php else: ?>
                        <?php if($all_page > 7): if($page <= 4 ): if($i > 7): break; ?>
                                <?php else: ?>
                                    <li><a href="#" style="color: #ffb751"><?php echo ($i); ?></a></li><?php endif; ?>
                            <?php elseif(($page > 4) AND ($page < ($all_page-3))): ?>
                                <?php if(($i >= ($page-3)) AND ($i <= ($page+3))): ?><li><a href="#" style="color: #ffb751"><?php echo ($i); ?></a></li><?php endif; ?>
                            <?php elseif($page >= ($all_page-3)): ?>
                                <?php if(($i >= $all_page-6)): ?><li><a href="#" style="color: #ffb751"><?php echo ($i); ?></a></li><?php endif; endif; ?>
                        <?php else: ?>
                            <li><a href="#" style="color: #ffb751"><?php echo ($i); ?></a></li><?php endif; endif; } ?>
                    <?php if($page < $all_page ): ?><li><a href="#" style="color: #ffb751">»</a></li><?php endif; endif; ?>
            </ul>

        </div>
    </div>
</div>
</div>