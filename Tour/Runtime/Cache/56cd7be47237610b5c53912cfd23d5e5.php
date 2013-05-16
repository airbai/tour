<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<title>后台管理</title>

	<link href="__ROOT__/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="__ROOT__/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
	<link href="__ROOT__/css/global.css" rel="stylesheet" type="text/css">
	<script src="__ROOT__/js/jquery.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/global.js" type="text/javascript" ></script>
	<link href="__ROOT__/css/admin/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>

<body>

	<div class="top_img" align="right">
		<!--
	  <table width="38%" border="0" cellpadding="0" cellspacing="0" style="margin-top:26px; color:#FF6E00;">
		<tr>
		  <td width="41%" align="left">专家团队：李黄河</td>
		  <td width="41%" align="left">用户：13888888888</td>
		  <td width="18%" align="left"><a href="#">退出</a></td>
		</tr>
		<tr>
		  <td align="left">指导老师：何长江</td>
		  <td colspan="2" align="left">身份：王牌客户</td>
		</tr>
	  </table>
	  -->
	</div>

	<div class="mid">
	  <div class="left">
		<!--
		<div class="left1">
		   <div class="left_te1"><img src="__ROOT__/images/admin/left1_03.jpg" /></div>
		   <div class="left_te2" align="center">
			 
		   </div>
		   <div class="left_te3"><img src="__ROOT__/images/admin/left1_07.jpg" /></div>
		</div>
		-->
		
		<div class="left2" style="margin:0;">
		  <div class="left2_1"><img src="__ROOT__/images/admin/left2_01.jpg" /></div>
		  <div class="left2_2">
			<ul>
				<li><span>全局信息管理</span></li>
				<li><a href="<?php echo U('Admin/home') ?>">管理首页</a></li>
				<li><a href="<?php echo U('Index/index') ?>">网站首页</a></li>
			</ul>
			<ul>
				<li><span>线路信息管理</span></li>
				<li><a href="<?php echo U('Admin/cLine') ?>">新增线路</a></li>
				<li><a href="<?php echo U('Admin/editLine') ?>">修改线路</a></li>
				<li><a href="<?php echo U('Admin/showLine') ?>">线路列表</a></li>
			</ul>
			<ul>
				<li><span>景点信息管理</span></li>
				<li><a href="<?php echo U('Admin/cPoint') ?>">新增景点</a></li>
				<li><a href="<?php echo U('Admin/editPoint') ?>">修改景点</a></li>
				<li><a href="<?php echo U('Admin/showPoint') ?>">景点列表</a></li>
			</ul>
			<ul>
				<li><span>订单信息管理</span></li>
				<li><a href="<?php echo U('Admin/editOrder') ?>">修改订单</a></li>
				<li><a href="<?php echo U('Admin/showOrder') ?>">订单列表</a></li>
			</ul>
			<ul>
				<li><span>代理信息管理</span></li>
				<li><a href="<?php echo U('Admin/cAgent') ?>">新增代理</a></li>
				<li><a href="<?php echo U('Admin/editAgent') ?>">修改代理</a></li>
				<li><a href="<?php echo U('Admin/showAgent') ?>">代理列表</a></li>
			</ul>
			<ul>
				<li><span>门票信息管理</span></li>
				<li><a href="<?php echo U('Admin/cTicket') ?>">新增门票</a></li>
				<li><a href="<?php echo U('Admin/editTicket') ?>">修改门票</a></li>
				<li><a href="<?php echo U('Admin/showTicket') ?>">门票列表</a></li>
			</ul>
		  </div>
		  <div class="left2_1"><img src="__ROOT__/images/admin/left2_02.jpg" /></div>
		</div>
	  </div>
	  
	  <div class="right">
		 <div class="right1"><?php echo ($pageTitle); ?></div>
			<div class="right2" align="center">
				<div class="right2_tt" align="left">



<link href="__ROOT__/css/admin/line.css" rel="stylesheet" media="screen">

<div id="line">
	<ul>
		<form method="post" action="<?php echo U('Admin/cOrder2Do') ?>" enctype="multipart/form-data">
		<input name="id" value="<?php echo ($order["id"]); ?>" style="display:none;">
		
		<li><span class="title" style="font-weight:bold;">门票信息</span></li>
		<?php foreach($ticketList as $item) { ?>
		<li>
			<span class="title">名称：</span>
			<input type="text" value="<?php echo ($item["name"]); ?>">
			<input name="ticket_id[]" type="text" value="<?php echo ($item["ticket_id"]); ?>" style="display:none"> 
		</li>
		<li>
			<span class="title">数量：</span>
			<input name="count[]" type="text" value="<?php echo ($item["count"]); ?>">
		</li>
		<li>
			<span class="title">单价：</span>
			<input name="unit_price[]" type="text" value="<?php echo ($item["unit_price"]); ?>">
		</li>
		<?php } ?>
		
		<li>&nbsp;</li>
		
		<li><span class="title" style="font-weight:bold;">保险信息</span></li>
		<?php foreach($insuranceList as $item) { ?>
		<li>
			<span class="title">保险：</span>
			<?php echo ($item["name"]); ?>
		</li>
		<li>
			<span class="title"></span>
			<input type="text" name="insurance[]" value="<?php echo ($item["count"]); ?>">
		</li>
		<?php } ?>
		
		<?php if (!empty($touristList)) { ?>
		<li><span class="title" style="font-weight:bold;">游客信息</span></li>
		<?php foreach ($touristList as $item) { ?>
		<li>
			<span class="title">游客姓名：</span>
			<input name="t_name[]" type="text" value="<?php echo $item['name'] ?>">
		</li>
		<li>
			<span class="title">游客联系方式：</span>
			<input name="t_phone[]" type="text" value="<?php echo $item['phone'] ?>">
		</li>
		<li>
			<span class="title">游客证件号：</span>
			<input name="t_card[]" type="text" value="<?php echo $item['card'] ?>">
		</li>
		<li>
			<span class="title">游客门票编号：</span>
			<input name="t_ticket_id[]" type="text" value="<?php echo $item['ticket_id'] ?>">
		</li>
		<li>&nbsp;</li>
		<?php } ?>
		<?php } ?>

		<li><span class="title">&nbsp;</span><input type="submit" class="btn btn-inverse" value="下一步"></li>
		</form>
		
	<div class="clear"></div>
	
</div>

			</div>
		</div>
	<div class="right3"><img src="__ROOT__/images/admin/right_b_03.jpg" /></div>
  </div>
</div>

<div style=" clear:both;"></div>
<div class="btt" align="center">
  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="18%" align="center"></td>
      <td width="82%" align="right"></td>
    </tr>
  </table>
</div>
</body>
</html>