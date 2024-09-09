<?php
/*
php /home/s/serjpozw/tooland/public_html/service/vse_t.php 1

Первый параметр - категория товара
    1 - Бензопилы
*/
?>

<?php
define('CRT', PHP_EOL);

if (isset($argv[1])) {
    echo CRT . 'Скрипт конвертации файлов для Woocoommerce' . CRT . CRT;
} else {
    echo CRT . 'До встречи!' . CRT;
    die;
}

switch ($argv[1]) {
    case 0:
        $cat_name = 'фрезерных';
        break;
    case 1:
        $cat_name = 'Бензопилы';
        break;
    case 3:
        $cat_name = 'Шуруповерты';
        break;
    case 311:
        $cat_name = 'Шуруповерты-Аккумуляторы';
        break;
    case 13:
        $cat_name = 'Газонокосилки';
        break;
    case 14:
        $cat_name = 'Генераторы';
        break;
    default:
        $cat_name = 'file';
}

// $output_file = fopen("./vse_out-" . $argv[1] . ".csv", "w");
$output_file = fopen("./vse_out_" . $argv[1] . '_' . $cat_name . ".csv", "w");
fputs($output_file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
$header_csv = 'Тип|';
$header_csv .= 'Артикул|';
$header_csv .= 'Имя|';
$header_csv .= 'Опубликован|';
$header_csv .= 'Видимость в каталоге|';
$header_csv .= 'Описание|';
$header_csv .= 'Базовая цена|';
$header_csv .= 'Категории|';
$header_csv .= 'Изображения|';
$header_csv .= 'Внешний URL|';
$header_csv .= 'Текст кнопки|';
$header_csv .= 'EAN|';
$header_csv .= 'Бренд';
fputcsv($output_file, explode('|', $header_csv), ';');

$input_file = fopen("./vse.csv", "r");
$row = 0;
$prod = 0;
while (($data_inp = fgetcsv($input_file, 0, ';')) !== FALSE) {
    $row++;

    if ($argv[1] == '0') {
        if (strpos($data_inp[2], 'Расходные материалы/Для станков/Оснастка для фрезерных станков') !== FALSE) {
            // $kat = 'Запчасти>Электродвигатели';
            $kat = str_replace('Расходные материалы/Для станков/Оснастка для фрезерных станков', 'Расходные материалы>Для станков>Оснастка для фрезерных станков', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    // if ($argv[1] == '0') {
    //     // Все для сада/Садовая техника/Триммеры/Бензиновые триммеры
    //     if (strpos($data_inp[2], 'Все для сада/Садовая техника/Триммеры/Бензиновые триммеры') !== FALSE) {
    //         $kat = str_replace('Все для сада/Садовая техника/Триммеры/Бензиновые триммеры', 'Бензоинструмент>Триммеры', $data_inp[2]);
    //         $kat = str_replace('/', '>', $kat);
    //         $kat = str_replace(',', ' и', $kat);
    //         echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
    //         out_str_to_csv($kat);
    //     }
    // }

    // if ($argv[1] == '0') {
    //     // Расходные материалы/Для садовой техники/Для бензопил/Шины
    //     if (strpos($data_inp[2], 'Расходные материалы/Для садовой техники/Для бензопил/Цепи') !== FALSE) {
    //         $kat = 'Расходные материалы>Для инструмента>Для бензопил>Цепи';
    //         echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
    //         out_str_to_csv($kat);
    //     }
    // }

    // if ($argv[1] == '0') {
    //     // Расходные материалы/Для садовой техники/Для бензопил/Шины
    //     if (strpos($data_inp[2], 'Расходные материалы/Для садовой техники/Для бензопил/Шины') !== FALSE) {
    //         $kat = 'Расходные материалы>Для инструмента>Для бензопил>Шины';
    //         echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
    //         out_str_to_csv($kat);
    //     }
    // }

    if ($argv[1] == '1') {
        // Бензопилы
        if (strpos($data_inp[13], 'бензопила') !== FALSE || strpos($data_inp[13], 'Бензопила') !== FALSE) {
            $kat = 'Бензоинструмент>Бензопилы';
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '11') {
        // Бензобуры
        if (
            strpos($data_inp[13], 'Мотобур') !== FALSE ||
            strpos($data_inp[13], 'Бензобур') !== FALSE
        ) {
            $kat = 'Бензоинструмент>Мотобуры';
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '12') {
        // Бензокультиваторы
        if (
            strpos($data_inp[13], 'Мотокультиватор') !== FALSE ||
            strpos($data_inp[13], 'Бензиновый культиватор') !== FALSE
        ) {
            $kat = 'Бензоинструмент>Культиваторы';
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '13') {
        // Газонокосилки Бензиновые
        if (strpos($data_inp[2], 'Газонокосилки/Бензиновые газонокосилки/') !== FALSE) {
            $kat = 'Бензоинструмент>Газонокосилки';
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '14') {
        // Генераторы (электростанции)/Бензиновые электростанции/
        if (strpos($data_inp[2], 'Инструмент/Генераторы (электростанции)/С возможностью работы на газу/') !== FALSE) {
            $kat = str_replace('Инструмент/Генераторы (электростанции)/С возможностью работы на газу/', 'Бензоинструмент>Генераторы>Газовые>', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            $kat = str_replace('(380 В и 380>220 В)', '(380 В и 380/220 В)', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '2') {
        // Пневмоинструмент
        if (strpos($data_inp[2], 'Инструмент/Пневмоинструмент/') !== FALSE) {
            $kat = str_replace('Инструмент/Пневмоинструмент/', 'Пневматический инструмент>', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '3') {
        // Шуруповерты
        if (strpos($data_inp[2], 'Инструмент/Шуруповерты/') !== FALSE && strpos($data_inp[13], 'шуруповерт') !== FALSE) {
            $kat = str_replace('Инструмент/Шуруповерты/', 'Электроинструмент>Шуруповерты>', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '311') {
        // Шуруповерты - Аккумуляторы
        if (strpos($data_inp[2], 'Инструмент/Аккумуляторный инструмент/Аккумуляторы') !== FALSE) {
            $kat = str_replace('Инструмент/Аккумуляторный инструмент/Аккумуляторы', 'Расходные материалы>Для инструмента>Аккумуляторные батареи', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '31') {
        // Инверторные полуавтоматы (MIG-MAG)
        if (strpos($data_inp[2], 'Сварочные полуавтоматы (MIG-MAG)') !== FALSE) {
            $kat = str_replace('Инструмент/Сварочное оборудование', 'Электроинструмент>Сварочное оборудование', $data_inp[2]);
            $kat = str_replace('MIG/MAG', 'MIG-MAG', $kat);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '32') {
        // Аргоновая сварка (TIG)
        if (strpos($data_inp[2], 'Дуговая сварка (ММА)') !== FALSE) {
            $kat = str_replace('Инструмент/Сварочное оборудование', 'Электроинструмент>Сварочное оборудование', $data_inp[2]);
            // $kat = str_replace('MIG/MAG', 'MIG-MAG', $kat);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '4') {
        // Ручной инструмент
        if (strpos($data_inp[2], 'Ручной инструмент/') !== FALSE) {
            $kat = str_replace('/', '>', $data_inp[2]);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '5') {
        // Электрика и свет
        if (strpos($data_inp[2], 'Электрика и свет/') !== FALSE) {
            $kat = str_replace('Электрика и свет/', 'Электрика и освещение>', $data_inp[2]);
            $kat = str_replace('/', '>', $kat);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    if ($argv[1] == '6') {
        // Расходные материалы/Для инструмента
        if (strpos($data_inp[2], 'Расходные материалы/Для инструмента/') !== FALSE) {
            $kat = str_replace('/', '>', $data_inp[2]);
            $kat = str_replace(',', ' и', $kat);
            echo $row . ' ' . $data_inp[13] . ' ' . $data_inp[11] . CRT;
            out_str_to_csv($kat);
        }
    }

    // if ($prod < 50) continue; // пропускаем первые 50 товаров
    // if ($prod > 50) break; // максимум 1000 товаров
    // if ($prod > 1000) break; // максимум 1000 товаров
}

fclose($input_file);
fclose($output_file);
echo CRT . 'Найдено ' . $prod . ' товаров' . CRT;
echo 'Работа скрипта успешно завершена. ' . date("H:i:s") . PHP_EOL;


/**
 * Вывод строки в файл csv 
 */
function out_str_to_csv($kategory)
{
    global $data_inp, $output_file, $prod;
    $str_to_csv = 'external|'; // тип
    $str_to_csv .= 'vse-' . $data_inp[9] . '|'; // артикул
    $str_to_csv .= $data_inp[13] . ' ' . $data_inp[11] . '|'; // имя
    $str_to_csv .= '1|'; // опубликовано
    $str_to_csv .= 'visible|'; // видимовсть

    $str_to_csv .= $data_inp[6]; // описание
    if ($data_inp[8]) {
        $str_to_csv .= '<h4>Комплектация:</h4>';
        $str_to_csv .= $data_inp[8] . '<br>';
    }

    if (mb_strlen(trim($data_inp[15])) > 0) {
        $str_to_csv .= '<h4>Характеристики:</h4>';
        $arr_h = explode('|', ($data_inp[15]));
        $str_to_csv .= '<table border="1" style="border-collapse: collapse";>';
        foreach ($arr_h as $item) {
            $str_to_csv .= '<tr>';
            $str_to_csv .= '<td>' . str_replace(':', '</td><td>', $item) . '</td>';
            $str_to_csv .= '</tr>';
        }
        $str_to_csv .= '</table>';
    }
    $str_to_csv .= '|';

    $str_to_csv .= $data_inp[17] . '|'; // базовая цена
    $str_to_csv .= $kategory . '|'; // категория
    $str_to_csv .= $data_inp[16] . '|'; // картинка
    $str_to_csv .= $data_inp[21] . '|'; // url
    $str_to_csv .= 'Купить|'; // текст кнопки
    $str_to_csv .= $data_inp[1] . '|'; // ean
    $str_to_csv .= $data_inp[22]; // бренд
    fputcsv($output_file, explode('|', $str_to_csv), ';');
    $prod++;
    // echo 'Добавляем товар (' . $prod . '): ' . $data_inp[10] . '<br>';
}
