<?php

  // $sql = "select id,m_name,m_time,m_price,actor,m_director,picurl,content from movie";
	$sql = 'select m.m_name,m.m_price,m.actor,m.m_director,m.m_time,m.content,m.picurl,r.m_id from relss as r left join movie as m on m.id = r.m_id group by r.m_id';

  require_once('./Model/Model.class.php');

  $model = new Model();

  $movieData = $model->select($sql);

  // echo '<pre>';
  // print_r($movieData);

  include './View/index.html';
