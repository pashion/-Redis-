<?php


	/*
		下单
		buying:场次id r_id
			order_id ==> {order_code,num,s_code,phone,static,order_time}

	*/
	$res[':static'] = 1;
	$res[':buy_time'] = time();

	$pdo = new PDO('mysql:host=localhost;dbname=dy;charset=utf8;port=3306','root','123456');
	$sql = 'update morder set static = 0,buy_time='.$res[':buy_time'].' where id = '.$_POST['order_id'];
	$num = $pdo->exec($sql);
	if($num){

		//查询当前影片所有已售座位
		echo '付款成功,请到影厅后,根据手机订单号取票后观影';
	}else{
		echo '付款失败';
	}






 ?>
