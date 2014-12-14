<?php
    require('header.php');
    $reco_sql = "SELECT * FROM dish WHERE reco = 1;";
    $reco_result = mysql_query($reco_sql);
?>
<section id="recommend"></section>
<script>
    var list = [
        <?php
            while ($reco_row = mysql_fetch_array($reco_result)) {
                echo "{content: '<div class=list id=list1><a href=><img src=".$reco_row["image"]."><p class=reco-name>".$reco_row["name"]."</p><p class=reco-price>".$reco_row["price"]."<span class=yuan>元</span></p></a>'},";
            }
        ?>
    ];
    var islider = new iSlider({
        type: 'dom',
        data: list,
        dom: document.getElementById('recommend'),
        isLooping: true,
        isAutoPlay: true,
        duration: 1000,
        onslidechange: function(idx) {
            islider.changeIndexDot();
        }
    });
    islider.renderDot({
            top: '220px',
            width: '90%',
            diameter: '0.8em',
            borderColor: '#fff',
    });
</script>
<section id="special">
    <div class="sp-head">
        <h2>今日特价</h2>
        <a href="" class="so-more">更多 ></a>
    </div>
    <div id="so-box">
        <?php
            $so_sql = "SELECT * FROM dish WHERE spec = 1 LIMIT 3;";
            $so_result = mysql_query($so_sql);
            while ($so_row = mysql_fetch_array($so_result)) {
                echo '<div class="so-dish"><a href=""><img src="'.$so_row["image"].'" alt=""><p>'.$so_row["name"].'</p><p><span class="so-price">'.$so_row["specialprice"].'元</span> <span class="ori-price">'.$so_row["price"].'元</span></p></a></div>';
            }
        ?>
    </div>
</section>
<section id="dish-box">
    <div id="sort-nav">
        <h2>全部菜肴</h2>
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
        $all_sql = "SELECT * FROM dish ORDER BY id DESC LIMIT 1;";
        $all_result = mysql_query($all_sql);
        $all_row = mysql_fetch_array($all_result);
        echo '<a href=""><dl><dt style="background-image: url('.$all_row["image"].');"></dt><dd><h3>'.$all_row["name"].'</h3><p class="all-skecth">'.$all_row["sketch"].'</p><p class="all-price">'.$all_row["price"].'元</p></dd></dl></a>';
    ?>
    </div>
</section>
<div class="load-more" id="load-more"><span>&#xe6c6;</span>加载中</div>