<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>SVD</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: "思源黑体 CN Light";
        }
        table {
            border-collapse: collapse;
            border: none;
            margin: 1em auto;
        }
        .ttitle {
            background: #00A0FF;
            color: #fff;
        }
        .ttitle td {
            padding-left: 2px;
        }
        td {
            width: 5em;
            /*padding: 0 1em;*/
            line-height: 2em;
            text-align: center;
            border: 1px solid #bdbdbd;
        }
        .index {
            text-align: center;
            font-weight: bold;
            background: #e0e0e0;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    require('svd.php');
    // require('../config.php');
    // $reco = new RECO();
    // for ($i = 0; $i < 5; $i++) {
        // $reco->recommend(8, $mysqli);
    // }
    /**
    * 推荐
    */
    class RECO {
        // private $itemTransformed;
        private function svdResolve($data) {
            $m = count($data);
            $n = count($data[0]);
            $u = array();
            $v = array();
            $c = array();
            $d = array();
            $m_ = $m*$m;
            for($i = 0; $i < $m_; $i++) {
                $u[$i] = 0;
            }
            $eps = 0.000001;
            $op = new OP();
            $dd = $op->oneDimen($data);
            new SVD($dd, $m, $n, $u, $v, $eps);
            $U = $op->twoDimen($u, $m, $m);
            $S = $op->twoDimen($dd, $m, $n);
            $V = $op->twoDimen($v, $n, $n);
            $this->showTable($U, 'U矩阵');
            $this->showTable($S, 'S矩阵');
            $this->showTable($V, 'VT矩阵');
            // $this->showTable($op->multiply($U, $op->trans($U)));
            // $this->showTable($op->multiply($op->multiply($U, $S), $V));
            $r = 0; // 统计需要的奇异值个数
            $m_1 = count($S); // S矩阵的行数
            $n_1 = count($S[0]); // S矩阵的列数
            $a = 0;
            for ($i = 0; $i < $m_1; $i++) {
                $a += $S[$i][$i] * $S[$i][$i]; // 记录全部奇异值平方和
            }
            $b = $a*0.90; // 全部奇异值的平方和的90%
            $c = 0;
            // print_r($S);
            for ($i = 0; $i < $n_1; $i++) {
                $c += pow($S[$i][$i], 2);
                if ($c >= $b) {
                    $r = $i + 1; // 统计前r个奇异值，反映全部奇异值的平方和的90%以上
                    break;
                }
            }
            echo '<h3>当取总奇异值平方和的'.(0.90*100).'%时，r为'.$r.'</h3>';
            $n_U = array();
            for ($i = 0; $i < $m; $i++) {
                $n_U[$i] = array();
                for ($j = 0; $j < $r; $j++) {
                    $n_U[$i][$j] = $U[$i][$j];
                }
            }
            $n_S = array();
            for ($i = 0; $i < $r; $i++) {
                $n_S[$i] = array();
                for ($j = 0; $j < $r; $j++) {
                    $n_S[$i][$j] = $S[$i][$j];
                }
            }
            $n_V = array();
            for ($i = 0; $i < $r; $i++) {
                $n_V[$i] = array();
                for ($j = 0; $j < $n; $j++) {
                    $n_V[$i][$j] = $V[$i][$j];
                }
            }
            // $this->showTable($n_S);
            // $oldData = $op->trans($data);
            // $op->ni($n_S);
            // $op->ni($n_S);
            // $itemTransformed = $op->multiply($op->multiply($oldData, $n_U), $n_S);
            // $this->showTable($itemTransformed);
            // return $itemTransformed;
            // $this->showTable($op->trans($n_V));
            return $op->trans($n_V);
        }
        public function createData($mysqli) {
            $user = array();
            $dish = array();
            $data = array();
            $dish_sql = "SELECT * FROM dish;";
            $dish_result = $mysqli->query($dish_sql);
            $dish_num = $dish_result->num_rows;
            $user_sql = "SELECT * FROM user;";
            $user_result = $mysqli->query($user_sql);
            $user_num = $user_result->num_rows;
            $user_sum = 0;
            while ($user_row = $user_result->fetch_array()) {
                /*if (!mysql_num_rows($mysqli->query("SELECT * FROM evaluate WHERE userid = ".$user_row['id'].";"))) {
                    continue;
                }*/
                $data[$user_sum] = array();
                $user[$user_sum] = $user_row['id'];
                $data[$user_sum] = array();
                $user_sum++;
                if ($user_sum == $dish_num) {
                    break;
                }
            }
            $dish_sum = 0;
            while ($dish_row = $dish_result->fetch_array()) {
                $dish[$dish_sum] = $dish_row['id'];
                $dish_sum++;
            }
            for ($i = 0; $i < $user_sum; $i++) {
                for ($j = 0; $j < $dish_sum; $j++) {
                    $star_result = $mysqli->query("SELECT * FROM evaluate WHERE userid = ".$user[$i]." AND dishid = ".$dish[$j]." ORDER BY createtime DESC;");
                    if (!$star_result->num_rows) {
                        $data[$i][$j] = 0;
                    } else {
                        $star = $star_result->fetch_array();
                        $data[$i][$j] = $star['star'];
                    }
                }
            }
            // $data = $this->svdResolve($data);
            return $data;
        }
        public function showTable($data, $title) {
            $m = count($data);
            $n = count($data[0]);
            echo '<table border="1"><tr class="ttitle"><td colspan="'.($n+1).'">'.$title.'</td></tr><tr class="index">';
            for ($i = 0; $i <= $n; $i++) {
                echo '<td>'.$i.'</td>';
            }
            echo '</tr>';
            for ($i = 0; $i < $m; $i++) {
                echo '<tr><td class="index">'.($i + 1).'</td>';
                for ($j = 0; $j < $n; $j++) {
                    echo '<td>';
                    echo round($data[$i][$j], 4);
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        public function evaluate($data, $user, $item, $itemTransformed) {
            // $this->showTable($data, '$data');
            $n = count($data[$user]);
            $simTotal = 0;
            $ratSimTotal = 0;
            for ($j = 0; $j < $n; $j++) {
                $userRating = $data[$user][$j];
                if ($userRating == 0 || $j == $item) {
                    continue;
                }
                $vectorA = $itemTransformed[$item];
                $vectorB = $itemTransformed[$j];
                $similarity = $this->cosSim($vectorA, $vectorB);
                echo 'the '.($item+1).' and '.($j+1).' similarity is '.$similarity.'<br>';
                $simTotal += $similarity;
                $ratSimTotal += $similarity * $userRating;
            }
            if ($simTotal == 0) {
                $score = 0;
            } else {
                $score = $ratSimTotal/$simTotal;
            }
            return $score;
        }
        public function cosSim($A, $B) {
            $a = 0;
            for ($i = 0; $i < count($A); $i++) {
                $a += $A[$i]*$B[$i];
            }
            $m = 0;
            $n = 0;
            for ($i = 0; $i < count($A); $i++) {
                $m += pow($A[$i], 2);
                $n += pow($B[$i], 2);
            }
            $b = sqrt($m)*sqrt($n);
            // echo abs($a).', '.$b.'<br>';
            return 0.5 + 0.5*$a/$b;
        }
        public function recommend($user, $mysqli) {
            $data = $this->createData($mysqli);
            /*$data = array(
                array(2,0,0,4,4,0,0,0,0,0,0,4,0,1,4,5),
                array(0,0,0,0,0,0,0,0,0,0,5,0,2,0,1,0),
                array(0,0,0,0,0,0,0,1,0,4,0,1,0,1,3,0),
                array(3,3,4,0,3,0,0,2,2,0,0,2,1,0,4,5),
                array(5,5,5,0,0,0,0,0,0,0,0,5,2,1,0,3),
                array(0,0,0,0,0,0,5,0,0,5,0,0,2,1,4,0),
                array(4,0,4,0,0,0,0,0,0,0,5,4,0,0,0,5),
                array(0,0,0,0,0,4,0,0,0,0,4,3,2,1,2,0),
                array(0,0,0,0,0,0,5,0,0,2,0,1,0,0,1,5),
                array(0,2,0,2,0,0,0,0,4,5,0,4,2,1,0,2),
                array(0,0,0,3,0,0,3,0,2,0,0,5,0,4,0,5),
                array(5,0,2,0,0,0,2,0,0,0,0,5,2,0,0,1),
                array(2,4,0,1,0,1,0,0,1,5,0,2,5,1,0,0),
                array(0,0,0,3,0,0,0,0,4,0,0,1,1,2,0,1),
                array(3,0,0,0,0,4,0,0,5,5,0,0,2,1,0,3),
                array(1,1,2,1,1,2,1,0,4,5,0,0,4,0,3,4)
            );*/
            // $data = array(
            //     array(5, 0, 2, 5),
            //     array(3, 2, 5, 2),
            //     array(5, 4, 1, 4)
            // );
            $op = new OP();
            $this->showTable($data, '评分矩阵');
            $m = count($data);
            $n = count($data[0]);
            $unratedItem = $this->createZeros(1, $n);
            $numOfUnrated = 0;
            for ($j = 0; $j < $n; $j++) {
                if ($data[$user][$j] == 0) {
                    $unratedItem[0][$j] = 1;
                    $numOfUnrated++;
                }
            }
            if ($numOfUnrated == 0) {
                echo 'the user has rated all items';
                return;
            }
            $this->showTable($unratedItem, '已评分项0，未评分项1');
            $itemScore = $this->createZeros($numOfUnrated, 2);
            $r = 0;
            // fillMatrix($data);
            $itemTransformed = $this->svdResolve($data);
            $this->showTable($itemTransformed, '降维后的矩阵');
            for ($j = 0; $j < $n; $j++) {
                if ($unratedItem[0][$j] == 1) {
                    $score = $this->evaluate($data, $user, $j, $itemTransformed);
                    $itemScore[$r][0] = ($j + 1);
                    $itemScore[$r][1] = $score;
                    $r++;
                }
            }
            $this->showTable($itemScore, '预测评分');
            $this->sort($itemScore);
            $this->showTable($op->trans($itemScore), '预测评分');
            return $this->store($itemScore);

        }
        public function createZeros($m, $n) {
            $array = array();
            for ($i = 0; $i < $m; $i++) {
                $array[$i] = array();
                for ($j = 0; $j < $n; $j++) {
                    $array[$i][$j] = 0;
                }
            }
            return $array;
        }
        public function sort(&$arr) {
            for ($i = 0; $i < count($arr); $i++) {
                $k = $i;
                for ($j = $i + 1; $j < count($arr); $j++) {
                    if ($arr[$k][1] < $arr[$j][1]) {
                        $temp0 = $arr[$k][0];
                        $temp1 = $arr[$k][1];
                        $arr[$k][0] = $arr[$j][0];
                        $arr[$k][1] = $arr[$j][1];
                        $arr[$j][0] = $temp0;
                        $arr[$j][1] = $temp1;
                    }
                }
            }
        }
        public function store($arr) {
            $data = '[';
            $count = 6;
            for ($i = 0; $i < $count; $i++) {
                $data .= $arr[$i][0];
                if ($i < $count - 1) {
                    $data .= ', ';
                }
            }
            $data .= ']';
            return $data;
        }
    }
?>
</body>
</html>