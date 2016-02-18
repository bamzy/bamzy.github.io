<?php
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$id = isset($_POST['id']) ? intval($_POST['id']) : -1;
$offset = ($page - 1) * $rows;
$result = array();

include 'conn.php';

//$rs = mysql_query("select count(*) from review");
if ($id == -1)
    $rs = mysql_query("SELECT review.`id` AS id,reviewer.`name` AS reviewerName, `manuscript`.`title` AS manuscriptTitle, review.`reviewContent` AS reviewDescription, review.`finalDecision` AS finalDecision FROM review,reviewer,manuscript WHERE (review.`manuscriptId`=`manuscript`.`id` AND review.`reviewerId`=reviewer.`id`)");
else
    $rs = mysql_query("SELECT review.`id` AS id,reviewer.`name` AS reviewerName, `manuscript`.`title` AS manuscriptTitle, review.`reviewContent` AS reviewDescription, review.`finalDecision` AS finalDecision FROM review,reviewer,manuscript WHERE (`review`.`manuscriptId`=$id AND `review`.`manuscriptId`=`manuscript`.`id` AND review.`reviewerId`=reviewer.`id`)");
$row = mysql_fetch_row($rs);
$result["total"] = $row[0];
if ($id == -1)
    $rs = mysql_query("SELECT review.`id` AS id,reviewer.`name` AS reviewerName, `manuscript`.`title` AS manuscriptTitle, review.`reviewContent` AS reviewDescription, review.`finalDecision` AS finalDecision FROM review,reviewer,manuscript WHERE (review.`manuscriptId`=`manuscript`.`id` AND review.`reviewerId`=reviewer.`id`) limit $offset,$rows");
else
    $rs = mysql_query("SELECT review.`id` AS id,reviewer.`name` AS reviewerName, `manuscript`.`title` AS manuscriptTitle, review.`reviewContent` AS reviewDescription, review.`finalDecision` AS finalDecision FROM review,reviewer,manuscript WHERE (`review`.`manuscriptId`=$id AND `review`.`manuscriptId`=`manuscript`.`id` AND review.`reviewerId`=reviewer.`id`)  limit $offset,$rows");

$items = array();
while ($row = mysql_fetch_object($rs)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);

?>