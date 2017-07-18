<?php

  //选座页面
  require_once('./Model/Model.class.php');

  $model = new Model();

  //获取到场次id
  $rid = @intval($_GET['rid']);

  //获取放映厅ID
  $hid = @intval($_GET['hid']);

  //查询当前场次信息
  $sql = 'select m_price,m_name,m_time,h_name,time,start_time,end_time,seating,id,h_id from relss where id =  ?';
  $rInfo = $model->select($sql, [$rid])[0];

  //查询放映厅座位
  $sql = 'select HallLayout from hall where id = ?';
  $hallInfo = $model->select($sql, [$hid])[0];

  //查询该电影在放映厅的售票信息
  $sql = 'select s_code from morder where r_id = ?';

  $saledInfo = $model->select($sql, [$rid]);
  // echo '<pre>';
  // print_r($saledInfo);

  $tmp = [];
  foreach ($saledInfo as $v) {

    $saleSeat = explode(',', $v['s_code']);

    foreach ($saleSeat as $v1) {

      array_push($tmp, $v1);
    }
    
  }


  include './View/select.html';
