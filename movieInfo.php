<?php

//电影详情页
require_once('./Model/Model.class.php');

$model = new Model();


//得到影片信息、买票情况
$sql = 'select m.m_name,m.m_type,m.m_time,m.actor,m.m_director,m.content,m.picurl,m.country_area,o.num from movie m left join morder o on m.id=o.m_id where m.id = ?';

$movieDetailData = $model->select($sql, array(intval($_GET['mid'])));
$movieDetailData = $movieDetailData[0];

//得到电影场次信息
$sql = 'select r.id,r.h_id,r.h_name,r.start_time,r.end_time,r.seating,r.m_price,o.num from relss r left join morder o on r.id = o.r_id where r.m_id=?';
$haltData = $model->select($sql, array(intval($_GET['mid'])));

// echo '<pre>';
// print_r($haltData);
include './View/detail.html';
