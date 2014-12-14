<?php
    require('config.php');
    sleep(1);
    $all_num = mysql_num_rows(mysql_query("SELECT * FROM dish;"));
    $page_size = 1;
    $page_num = intval($all_num / $page_size);
    if ($all_num % $page_size) {
        $page_num++;
    }
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        exit();
    }
    if ($page > $page_num) {
        echo "no more";
        exit();
    }
    $rule = $_GET['rule'];
    switch ($rule) {
        case 'default':
            $rule = "ORDER BY id DESC";
            break;
        case 'hprice':
            $rule = "ORDER BY price DESC";
            break;
        case 'lprice':
            $rule = "ORDER BY price";
            break;
        default:
            $rule = "ORDER BY id";
            break;
    }
    $offset = $page_size * ($page - 1);
    $page_sql = "SELECT * FROM dish ".$rule." LIMIT ".$offset.", ".$page_size.";";
    $page_result = mysql_query($page_sql);
    while ($page_row = mysql_fetch_array($page_result)) {
        echo '<a href=""><dl><dt style="background-image: url('.$page_row["image"].');"></dt><dd><h3>'.$page_row["name"].'</h3><p class="all-skecth">'.$page_row["sketch"].'</p><p class="all-price">'.$page_row["price"].'元</p></dd></dl></a>';
    }
?>