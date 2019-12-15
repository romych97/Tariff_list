<?php

// Проверяем название тарифа и страницу
if (isset($_POST['content_type']) && isset($_POST['page'])) {
    $content_type = $_POST['content_type'];
    $page = $_POST['page'];
} 
// Если Post с названием тарифа и страницой не получен
else {
    $content_type = '';
    $page = 0;
}

// 
function get_content($type, $page) {
    $data = json_decode(file_get_contents('https://www.sknt.ru/job/frontend/data.json'));
    // если post с названием и страницой не получен выгружаем список всех тарифов (переходим на первую страницу)
    if ($type == '' || $page == 1) {
        main_page($data);
    } elseif($page == 2) {
        second_page($data, $type);
    } elseif($page == 3) {
        third_page($data, $type, $_POST['prev']);
    }
}

function main_page($json) {
    echo '<div class="header_3"><div>Список тарифов</div></div><div class="content">';
    foreach ($json->tarifs as $key => $value) {
        $last_tarif_price = $value->tarifs[count($value->tarifs) - 1]->price;
        //print_r($value);
        echo '<div class="block" onclick="next(\''.$value->title.'\', \'2\')"><div class="block-header">Тариф "' . $value->title . '"</div>';

        echo '<div class="block-body"><div class="block-speed body-block">' . $value->speed . ' Мбит/c</div>';
        echo '<div class="block-price body-block">' . $value->tarifs[0]->price . ' - ' . $last_tarif_price . ' Рублей/мес</div>';
        if (!empty($value->free_options)) {
            echo '<div class="block-detail body-block">';
            foreach ($value->free_options as $k => $v) {
                echo $v . '</br>';
            }
            echo '</div>';
        }
        echo '</div><div class="block-more">Узнать подробнее на сайте ' . $value->link . 'l </div></div>';
    }
    echo '</div>';
}

function second_page($json, $tarif_type) {
    echo '<div class="header_3" onclick="return prev()"><button>&#8592;</button>';
    echo '<div>Тариф "' . $tarif_type . '"</div></div><div class="content">';
    // print_r($tarif_type);
        foreach ($json->tarifs as $key => $value) {

        // $last_tarif_price = $value->tarifs[count($value->tarifs) - 1]->price;
        //print_r($value);
            if ($value->title == $tarif_type) {
                foreach ($value->tarifs as $k => $v) {
                    // print_r($v);
                    echo '<div class="block" onclick="next(\''.$v->title.'\', \'3\', \'' . $tarif_type . '\')"><div class="block-header">Тариф "' . $v->title . '"</div>';
                    echo '<div class="block-body"><div class="body-block">Платежный цикл: ' . $v->pay_period . ' Месяц</div>';
                    echo '<div class="block-speed body-block">' . $v->price . ' Рублей/Месяц</div>';
                    echo '</div><div class="block-more"></div></div>';
            }
        }
    }
    echo "</div>";
}

function third_page($json, $tarif_type, $preview_page) {
    echo '<div class="header_3"><button onclick=prev("' . $preview_page . '",' . '"2"' . ')>&#8592;</button>';
    echo '<div>Выбор тарифа</div></div>';
        foreach ($json->tarifs as $key => $value) {
            foreach ($value->tarifs as $k => $v) {
                if ($v->title == $tarif_type) {
                echo '<div class="block block-choise"><div class="block-header">Тариф "' . $v->title . '"</div>';
                echo '<div class="block-body"><div class="body-block">Платежный цикл: ' . $v->pay_period . ' Месяц</div>';
                echo '<div class="block-speed body-block">' . $v->price . ' Рублей/Месяц</div>';
                echo '</div><div class="block-more block-choise"><button>Выбрать</button></div></div>';
             }
        }
    }
}

get_content($content_type, $page);
?>