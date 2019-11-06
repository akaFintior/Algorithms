<?php

$connect = mysqli_connect('localhost', 'root', '', 'alg') or die('Not connection');

$query = "SELECT * FROM categories";


$result = mysqli_query($connect, $query);
$cats = [];
while ($cat = mysqli_fetch_assoc($result)) {
    var_dump($cat);
    echo "<br>";
    $cats[$cat['parent_id']][$cat['id']] = $cat;
}
mysqli_close($connect);

function buildTree ($cats, $parent_id) {

    if(is_array($cats) && isset($cats[$parent_id])) {
        $tree = "<ul>";
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li>".$cat['name'];
            $tree .= buildTree($cats, $cat['id']);
            $tree .= "</li>";
        }
        $tree .="</ul>";
        return $tree;
    }
}

echo  buildTree($cats, 0) . PHP_EOL;

$connect = mysqli_connect('localhost', 'root', '', 'alg') or die('Not connection');

$queryTwo = "SELECT `c`.`id_category`, `c`.`category_name`, `cl`.`parent_id`, `cl`.`child_id`, `cl`.`level` FROM `categories_db` as `c` INNER JOIN `category_links` AS `cl` ON `cl`.`child_id` = `c`.`id_category` WHERE cl.parent_id = 1";

$result = mysqli_query($connect, $queryTwo);
$cats = [];
while ($cat = mysqli_fetch_assoc($result)) {
    var_dump($cat);
    echo "<br>";
    $cats[$cat['category_name']][$cat['level']][$cat['child_id']][$cat['parent_id']] = $cat;
}
mysqli_close($connect);

function buildMenu ($cats, $parent_id) {

    if (is_array($cats) && isset($cats[$parent_id])) {
        $tree = "<ul>";
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li>".$cat['category_name'];
            $tree .= buildMenu($cats, $cat['parent_id']);
            $tree .= "</li>";
        }
        $tree .= "</ul>";
        return $tree;
    }
}

echo buildMenu($cats, 0);