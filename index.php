<?php
    require('header.php');
    $reco_sql = "SELECT * FROM dish WHERE reco = 1;";
    $reco_result = $mysqli->query($reco_sql);
?>
<section id="recommend"></section>
<script>
    var list = [
        <?php
            while ($reco_row = $reco_result->fetch_array()) {
                echo "{content: '<div class=list id=list1><a href=detail.php?id=".$reco_row["id"]."><img src=".$reco_row["image"]."><p class=reco-name>".$reco_row["name"]."</p><p class=reco-price>".$reco_row["price"]."<span class=yuan>元</span></p></a>'},";
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
            top: '230px',
            width: '90%',
            height: '40px',
            diameter: '0.8em',
            borderColor: '#fff',
    });
</script>
<section id="special">
    <div class="sp-head">
        <h2>今日特价</h2>
        <a href="spec.php" class="so-more">更多 &gt;</a>
    </div>
    <div id="so-box">
        <?php
            $so_sql = "SELECT * FROM dish WHERE spec = 1 LIMIT 3;";
            $so_result = $mysqli->query($so_sql);
            while ($so_row = $so_result->fetch_array()) {
                echo '<div class="so-dish"><a href="detail.php?id='.$so_row["id"].'"><img src="'.$so_row["image"].'" alt=""><p>'.$so_row["name"].'</p><p><span class="so-price">'.$so_row["price"].'<span class="yuan">元</span> <span class="ori-price">'.$so_row["oriprice"].'元</span></p></a></div>';
            }
        ?>
    </div>
</section>
<section id="dish-box">
    <div id="sort-nav">
    <?php
        if (!isset($_SESSION['USERID'])) {
            echo '<h2>新品</h2>';
            echo '</div>';
            echo '<div class="page">';
            $all_sql = "SELECT * FROM dish ORDER BY id DESC LIMIT 6;";
            $all_result = $mysqli->query($all_sql);
            while ($all_row = $all_result->fetch_array()) {
                if ($all_row["spec"]) {
                    $price = '<span><span class="so-price">'.$all_row["price"].'<span class="yuan">元</span> <span class="ori-price">'.$all_row["oriprice"].'元</span></span>';
                } else {
                    $price = '<p class="all-price">'.$all_row["price"].'<span class="yuan">元</p>';
                }
                echo '<a href="detail.php?id='.$all_row["id"].'"><dl class="dish-dl"><dt class="dish-dt" style="background-image: url('.$all_row["image"].');"></dt><dd class="dish-dd"><h3>'.$all_row["name"].'</h3><p class="all-skecth">'.$all_row["sketch"].'</p>'.$price.'<p class="sell-num">已售'.$all_row["sellnum"].'份</p></dd></dl></a>';
            }
            echo '</div>';
        } else {
            echo '<h2>猜你喜欢</h2>';
            echo '</div>';
            echo '<div class="page">';
            $data = $mysqli->query("SELECT * FROM user WHERE id = ".$_SESSION['USERID'].";")->fetch_array();
            $data = json_decode($data['reco']);
            for ($i = 0; $i < count($data); $i++) {
                $sql = "SELECT * FROM dish WHERE id = ".$data[$i].";";
                $row = $mysqli->query($sql)->fetch_array();
                if ($row["spec"]) {
                    $price = '<span><span class="so-price">'.$row["price"].'<span class="yuan">元</span> <span class="ori-price">'.$row["oriprice"].'元</span></span>';
                } else {
                    $price = '<p class="all-price">'.$row["price"].'<span class="yuan">元</p>';
                }
                echo '<a href="detail.php?id='.$row["id"].'"><dl class="dish-dl"><dt class="dish-dt" style="background-image: url('.$row["image"].');"></dt><dd class="dish-dd"><h3>'.$row["name"].'</h3><p class="all-skecth">'.$row["sketch"].'</p>'.$price.'<p class="sell-num">已售'.$row["sellnum"].'份</p></dd></dl></a>';
            }
        }
    ?>
</section>
<?php
    require('footer.php');
?>