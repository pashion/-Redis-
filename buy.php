<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>选座购票</title>
	<style type="text/css">

		#movie{width: 800px;margin: 0 auto;}
		#m_info{width: 349px;float: left;border-right:1px solid #333;}
		#m_order{width: 400px;height: 200px;float: left;margin-left: 50px;}
		p{text-align:left;color: #777;}
		p span{font-size:18px;color:#333;}
		#code{width: 900px;margin: 0 auto;overflow-x: scroll;}
		 .seatCharts{width: 35px;height: 35px;border-radius:5px;margin: 2px;float: left;}
		 .available{background-color: #b9dea0;}
		 .selected{background-color: #e6cac4;}
		 .available:hover{background-color: #76b474;}
		 .clear{clear:both;}
		#seat-map{ border-right: 1px dotted #adadad;

				    list-style: outside none none;
				    max-height: 600px;
				    overflow-x: auto;
				    padding: 20px;
				    width: 1200px;}
	</style>
</head>
<body>
	<?php
		// $pdo = new PDO('mysql:host=localhost;dbname=dy;charset=utf8;port=3306','root','');
		$sql = 'select m.num,m.s_code,m.phone,m.r_id,r.m_name,r.h_name,r.time,r.m_time,r.start_time,r.end_time,r.m_price,r.m_id from morder m left join relss r on m.r_id=r.id where m.id =?';
		// $stmt = $pdo->query($sql);
		// $res = $stmt->fetch(PDO::FETCH_ASSOC);
		require_once('./Model/Model.class.php');

		$model = new Model();

		$res = $model->select($sql, [$_GET['order_id']])[0];
		$str = '';
		foreach (explode(',',$res['s_code']) as $k => $v) {
			$b = explode('_',$v);
			$str .= $b[0].'排'.$b[1].'座&nbsp;&nbsp;';
		}


	 ?>

	<form action="./dobuy.php" method="post">
	<div id="movie">
		<br><br><br>
		<div id="m_info">
			<p>影片名称:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['m_name']; ?></span></p>
			<p>放映厅:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['h_name']; ?></span></p>
			<p>影片时长:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['m_time']; ?>分钟</span></p>
			<p>日期:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['time'];?></span></p>
			<p>时间:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['start_time'].'-----'.$res['end_time']; ?></span></p>
		</div>
		<div id="m_order">
			<p>手机号:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['phone']; ?></span></p>
			<p>数量:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['num']; ?></span></p>
			<p>座位:&nbsp;&nbsp;&nbsp;<span ><?php echo $str; ?></span></p>
			<p>单价:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['m_price']; ?>&nbsp;&nbsp;元</span></p>
			<p>总计:&nbsp;&nbsp;&nbsp;<span ><?php echo $res['m_price']*$res['num']; ?>&nbsp;&nbsp;元</span></p>
		</div>
		<div style="clear:both"></div>
		<input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">
		<input type="hidden" name="r_id" value="<?php echo $res['r_id']; ?>">
		<input type="hidden" name="m_id" value="<?php echo $res['m_id']; ?>">
		<h3><span>请核对以上信息,如确认无误后,请您在2分钟之内完成付款操作</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
		<button style="background-color: #d9534f;border-color: #d43f3a;color: #fff;font-size: 18px;">确认付款</button>
		<hr>
	</div>
	</form>
	<div style="width: 100%;height: 100px;clear:both"></div>


</body>
</html>
