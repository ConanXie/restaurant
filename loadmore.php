<?php
    require('config.php');
    sleep(1);
    switch ($_GET['cate']) {
        case 'all':
            $cond = '';
            break;
        default:
            $cond = "WHERE dishcate = ".$_GET['cate'];
            break;
    }
    $all_num = mysql_num_rows(mysql_query("SELECT * FROM dish ".$cond.";"));
    $page_size = 4;
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
            $rule = "id DESC";
            break;
        case 'sell':
            $rule = "sellnum DESC";
            break;
        case 'cart':
            $rule = "cartnum DESC";
            break;
        case 'hprice':
            $rule = "price DESC";
            break;
        case 'lprice':
            $rule = "price";
            break;
        default:
            $rule = "id";
            break;
    }
    $offset = $page_size * ($page - 1);
    $page_sql = "SELECT * FROM dish ".$cond." ORDER BY ".$rule." LIMIT ".$offset.", ".$page_size.";";
    $page_result = mysql_query($page_sql);
    while ($page_row = mysql_fetch_array($page_result)) {
        if ($page_row["spec"]) {
            $price = '<span><span class="so-price">'.$page_row["price"].'<span class="yuan">元</span> <span class="ori-price">'.$page_row["oriprice"].'元</span></span>';
        } else {
            $price = '<p class="all-price">'.$page_row["price"].'<span class="yuan">元</p>';
        }
        echo '<a href="detail.php?id='.$page_row["id"].'"><dl class="dish-dl"><dt class="dish-dt" style="background-image: url('.$page_row["image"].');"></dt><dd class="dish-dd"><h3>'.$page_row["name"].'</h3><p class="all-skecth">'.$page_row["sketch"].'</p>'.$price.'<p class="sell-num">已售'.$page_row["sellnum"].'份</p></dd></dl></a>';
    }
?>