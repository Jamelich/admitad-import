<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require 'convert.php';
$cn = new Convertor('Расходные материалы/Для станков/Оснастка для фрезерных станков', 'Расходные материалы>Для станков>Оснастка для фрезерных станков');
$cn->get_file_out();
