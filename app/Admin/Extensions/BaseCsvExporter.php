<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;

abstract class BaseCsvExporter extends ExcelExporter
{
    /**
     * {@inheritdoc}
     */
    public function export()
    {
        $titles = $this->headings();
        $filename = $this->fileName;
        $data = $this->getData();
        $output = $this->putcsv($titles);

        foreach ($data as $row) {
            $output .= $this->putcsv($row);
        }

        $headers = [
            'Content-Encoding'    => 'UTF-8',
            'Content-Type'        => 'text/csv; UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        response(rtrim($output, "\n"), 200, $headers)->send();

        exit;
    }

    /**
     * Приводим массив в строку в виде CSV
     *
     * @param array  $row
     * @param string $delimiter
     * @param string $quot
     *
     * @return string
     */
    protected function putCsv(array $row, string $delimiter = ';', string $quot = '"'): string
    {
        $str = '';
        foreach ($row as $cell) {
            $cell = str_replace([$quot, "\n"], [$quot . $quot, ''], $cell);
            if (strstr($cell, $delimiter) !== false || strstr($cell, $quot) !== false) {
                $str .= $quot . $cell . $quot . $delimiter;
            } else {
                $str .= $cell . $delimiter;
            }
        }

        return iconv("utf-8", "windows-1251//TRANSLIT//IGNORE", substr($str, 0, -1) . "\n");
    }

}
