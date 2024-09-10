<?php
class Convertor
{
    public $in_cat;
    public $out_cat;
    private $input_file;
    private $output_file;
    private $data_inp;
    private $prod;

    public function __construct($in_cat, $out_cat)
    {
        $this->in_cat = $in_cat;
        $this->out_cat = $out_cat;
    }

    // получаем выходной файл
    public function get_file_out()
    {
        $this->input_file = fopen("./vse.csv", "r");
        $filename_out = str_replace(' ', '-', mb_substr($this->out_cat, mb_strrpos($this->out_cat, '>') + 1, strlen($this->out_cat))) . '.csv';
        $this->output_file = fopen("./" . $filename_out . ".csv", "w");
        fputs($this->output_file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
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
        fputcsv($this->output_file, explode('|', $header_csv), ';');

        $this->prod = 1;
        $this->get_prod_info();

        fclose($this->input_file);
        fclose($this->output_file);
        echo PHP_EOL . 'Найдено ' . ($this->prod - 1) . ' товаров' . PHP_EOL;
        echo 'Работа скрипта успешно завершена. ' . date("H:i:s") . PHP_EOL;
    }

    //  Вывод строки в файл csv 
    public function out_str_to_csv($kategory)
    {
        $str_to_csv = 'external|'; // тип
        $str_to_csv .= 'vse-' . $this->data_inp[9] . '|'; // артикул
        $str_to_csv .= $this->data_inp[13] . ' ' . $this->data_inp[11] . '|'; // имя
        $str_to_csv .= '1|'; // опубликовано
        $str_to_csv .= 'visible|'; // видимовсть

        $str_to_csv .= $this->data_inp[6]; // описание
        if ($this->data_inp[8]) {
            $str_to_csv .= '<h4>Комплектация:</h4>';
            $str_to_csv .= $this->data_inp[8] . '<br>';
        }

        if (mb_strlen(trim($this->data_inp[15])) > 0) {
            $str_to_csv .= '<h4>Характеристики:</h4>';
            $arr_h = explode('|', ($this->data_inp[15]));
            $str_to_csv .= '<table border="1" style="border-collapse: collapse";>';
            foreach ($arr_h as $item) {
                $str_to_csv .= '<tr>';
                $str_to_csv .= '<td>' . str_replace(':', '</td><td>', $item) . '</td>';
                $str_to_csv .= '</tr>';
            }
            $str_to_csv .= '</table>';
        }
        $str_to_csv .= '|';

        $str_to_csv .= $this->data_inp[17] . '|'; // базовая цена
        $str_to_csv .= $kategory . '|'; // категория
        $str_to_csv .= $this->data_inp[16] . '|'; // картинка
        $str_to_csv .= $this->data_inp[21] . '|'; // url
        $str_to_csv .= 'Купить|'; // текст кнопки
        $str_to_csv .= $this->data_inp[1] . '|'; // ean
        $str_to_csv .= $this->data_inp[22]; // бренд
        return $str_to_csv;
    }

    // Сбор информации из файла
    public function get_prod_info()
    {
        while (($this->data_inp = fgetcsv($this->input_file, 0, ';')) !== FALSE) {
            if (strpos($this->data_inp[2], $this->in_cat) !== FALSE) {
                $kat = str_replace($this->in_cat, $this->out_cat, $this->data_inp[2]);
                $kat = str_replace('/', '>', $kat);
                $kat = str_replace(',', ' и', $kat);
                echo $this->prod . ') ' . $this->data_inp[13] . ' ' . $this->data_inp[11] . '<br>';
                fputcsv($this->output_file, explode('|', $this->out_str_to_csv($kat)), ';');
                $this->prod++;
            }
            if ($this->prod > 50) break; // максимум 50 товаров
        }
    }
}
