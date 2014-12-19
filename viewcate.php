<?php
    require('header.php');
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ".$config_basedir);
        exit();
    } else {
        $cate_sql = "SELECT * FROM dishcate WHERE id = ".$_GET['id'].";";
        $cate_row = mysql_fetch_array(mysql_query($cate_sql));
        ?>
        <section id="dish-box">
            <div id="sort-nav" style="margin-top: 0;">
                <h2><?php echo $cate_row["cate"]; ?></h2>
                <h4 id="now-sort">默认排序<span>&#xe8a1;</span></h4>
                <ul id="rule-list">
                    <li class="sort-rule now-rule" data-rule="default">默认排序</li>
                    <li class="sort-rule" data-rule="sell">销售排序</li>
                    <li class="sort-rule" data-rule="cart">购物车排序</li>
                    <li class="sort-rule" data-rule="hprice">价格从高到低</li>
                    <li class="sort-rule" data-rule="lprice">价格从低到高</li>
                </ul>
            </div>
            <div class="page">
        <?php
        $dish_sql = "SELECT * FROM dish WHERE dishcate = ".$_GET['id']." ORDER BY id DESC LIMIT 4;";
        $dish_result = mysql_query($dish_sql);
        while ($dish_row = mysql_fetch_array($dish_result)) {
            if ($dish_row["spec"]) {
                $price = '<span><span class="so-price">'.$dish_row["price"].'<span class="yuan">元</span> <span class="ori-price">'.$dish_row["oriprice"].'元</span></span>';
            } else {
                $price = '<p class="all-price">'.$dish_row["price"].'<span class="yuan">元</p>';
            }
            echo '<a href="detail.php?id='.$dish_row["id"].'"><dl class="dish-dl"><dt class="dish-dt" style="background-image: url('.$dish_row["image"].');"></dt><dd class="dish-dd"><h3>'.$dish_row["name"].'</h3><p class="all-skecth">'.$dish_row["sketch"].'</p>'.$price.'<p class="sell-num">已售'.$dish_row["sellnum"].'份</p></dd></dl></a>';
        }
    }
?>
</div>
</section>
<div class="load-more" id="load-more"><span>&#xe6c6;</span>加载中</div>
<script>
    var theDish = new Dish(<?php echo $_GET['id']; ?>);
    window.onscroll = theDish.onscroll;
</script>
<?php
    require('footer.php');
?>