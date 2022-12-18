<?php

return [
    'default_files_provider' => env('DEFAULT_FILES_PROVIDER', 'specification.excel'),
    'temp_directory' => env('TEMP_DIRECTORY', public_path() . DIRECTORY_SEPARATOR . 'projects-temp' . DIRECTORY_SEPARATOR),

    'files_providers' => [
        'ru' => [
            'specification.excel' => [
                'clean_blank_path' => env('CLEAN_EXCEL_BLANK_PATH', DIRECTORY_SEPARATOR . 'clear_blanks' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'ru' . DIRECTORY_SEPARATOR . 'project-specification.xlsx'),
                'blanks_path' => env('EXCEL_BLANKS_PATH', 'blanks' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'ru' . DIRECTORY_SEPARATOR . 'project-specifications' . DIRECTORY_SEPARATOR),
                'sheet_names' => [
                    'products' => env('EXCEL_SHEET_NAME','Товары'),
                    'specification' => env('EXCEL_SHEET_NAME','Спецификация'),
                ],
                'header_height' => env('EXCEL_HEADER_HEIGHT',2),
            ],
        ],
        'en' => [
            'specification.excel' => [
                'clean_blank_path' => env('EN_CLEAN_EXCEL_BLANK_PATH', DIRECTORY_SEPARATOR .'clear_blanks' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'en' . DIRECTORY_SEPARATOR . 'project-specification.xlsx'),
                'blanks_path' => env('EN_EXCEL_BLANKS_PATH', 'blanks' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'en' . DIRECTORY_SEPARATOR . 'project-specifications' . DIRECTORY_SEPARATOR),
                'sheet_names' => [
                    'products' => env('EN_EXCEL_SHEET_NAME','Products'),
                    'specification' => env('EN_EXCEL_SHEET_NAME','Specification'),
                ],
                'header_height' => env('EN_EXCEL_HEADER_HEIGHT',2),
            ],
        ],
    ],
];
