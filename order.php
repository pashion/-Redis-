<?php

//判断数据是否完整
if(empty($_POST['phone']) || empty($_POST['s_code'])){

  $str = '<script type="text/javascript">
    alert("请填写您的手机号,并选中您所要购买的座位");
    location.href="'.$_SERVER['HTTP_REFERER'].'";
  </script>';
  echo $str;die;

}


require_once('./Model/Model.class.php');

$model = new Model();


//拼接订单数据
$data[':order_code'] = uniqid();//订单id
$data[':r_id'] = $_POST['r_id'];//对应场次
$data[':m_id'] = $_POST['r_id'];//对应电影
$data[':num'] = count($_POST['s_code']);//数量
// $data['s_code'] = json_encode($_POST['s_code']);//座位号
$data[':s_code'] = implode(',',$_POST['s_code']);//座位号
$data[':phone'] = $_POST['phone'];//手机号
$data[':static'] = 1;//状态,0已支付,1未支付,2取消
$data[':order_time'] = time();//下单时间


//检查座位是否被购买
$sql = 'select s_code from morder where r_id = ?';
$haveSale = $model->select($sql, [$_POST['r_id']]);

// echo '<pre>';
// print_r($haveSale);
// print_r($_POST['s_code']);

foreach ($haveSale as $v) {

  $haveSaleArr = explode(',', $v['s_code']);

  foreach ( $_POST['s_code'] as $v ) {

    if ( in_array($v, $haveSaleArr) ) {

      echo '<script type="text/javascript">
        alert("您所选中的座位,已经被锁定,请更换");
        location.href="'.$_SERVER['HTTP_REFERER'].'";
      </script>';

      die;
    }
  }
}

//生成订单
$pdo = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8;port=3306','root','123456');
$sql = 'insert into morder(order_code,r_id,m_id,num,s_code,phone,static,order_time) values(:order_code,:r_id,:m_id,:num,:s_code,:phone,:static,:order_time)';
$stmt = $pdo->prepare($sql);
//执行
$stmt->execute($data);
//受影响行数
$num = $stmt->rowCount();

if($num){
  //最后插入id
  $id = $pdo->lastInsertId();

/*
    下单
    buying:场次id r_id
      order_id ==> {order_code,num,s_code,phone,static,order_time}
  */

  // 跳转页面
  header('location:./buy.php?order_id='.$id);

}else{

  echo '<script type="text/javascript">
    alert("下单失败");
    location.href="'.$_SERVER['HTTP_REFERER'].'";
  </script>';
  die;
}



// print_r($haveSaleArr);
