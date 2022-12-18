<?php

return [
    'list' => 'Мои проекты',
    'create' => 'Создание проекта',
    'details' => 'Детали проекта ":title"',
    'update' => 'Редактирование проекта ":title"',
    'products' => 'Добавленная продукция проекта ":title"',
    'specifications' => 'Спецификация проекта ":title"',
    'validation' => [
        'no-owner' => 'Вы не являетесь владельцем проекта',
        'product_belong_specification' => 'Ошибка в товаре или спецификации.',
        'section_belong_specification' => 'Ошибка в разделе или спецификации.',
        'product_belong_section' => 'Ошибка в товаре или разделе.',
        'min_product_amount' => 'Товар используется в спецификации. Кол-ство товара должно быть не меньше :min_amount.',
        'product_used_in_specification' => 'Товар используется в спецификации. Его нельзя отсюда удалить.',
        'change_belong_project' => 'Ошибка в изменении или проекте.',
        'one_project_for_guest' => 'У не авторизированого пользователя может быть только 1 проект.',
        'category_has_products' => 'В этой категории есть товары в рамках данного проекта.',
    ],
    'file' => [
        'vendor_code' => 'Артикул',
        'name' => 'Наименование',
        'amount' => 'Количество',
        'real_price' => 'Розничная цена',
        'note' => 'Примечание',
        'in_stock' => 'В наличии',
        'in_stock_val' => 'Да',
        'not_in_stock_val' => 'Нет',
        'section' => 'Раздел',
        'discount' => 'Скидка',
        'price_with_discount' => 'Цена со скидкой',
        'total_price' => 'Стоимость',
        'boolean_check_word' => 'Да',
    ],
    'changes' => [
        'in_stock_yes' => 'Появилось в наличии',
        'in_stock_no' => 'Нет в наличии',
        'amount_up' => 'Количество увеличенно',
        'amount_down' => 'Количество уменьшенно',
        'real_price_up' => 'Цена стала выше',
        'real_price_down' => 'Цена стала ниже',
        'discount_up' => 'Скидка стала выше',
        'discount_down' => 'Скидка стала ниже',
        'removed' => 'Позиция удалена',
        'added' => 'Позиция добавлена',
        'analog' => 'Подобран аналог',
    ],
    'upload_notices' => [
        'spreadsheet_sheet_doesnt_exists' => 'Лист ":sheet_name" отсутствует в документе. Проверьте, точно ли вы загрузили такой же файл, который скачивали в разделе генерации бланка спицефикации.',
        'invalid_spreadsheet_headers' => 'В загруженном файле отличаются заголовки от тех, которые мы вам давали. Проверьте, точно ли вы загрузили такой же файл, который скачивали в разделе генерации бланка сметы.',
        'spreadsheet_cell_unexpected_value' => 'В ячейке :cell ожидалось получить ":expectation", но получили ":reality".',

        'invalid_product_amount' => 'Ошибка количества товара.',
        'details_product_amount' => 'Количество товара :vendor_code в разделе добавленных продуктов меньше, чем использовано в спецификации.',

        'invalid_product_data' => 'Ошибка в данных товара в строке :row.',
        'invalid_product_data_vendor_code' => 'Артикул не может быть пустым.',
        'invalid_product_data_amount' => 'Количество должно быть цифрой от 1 до 100.',
        'invalid_product_data_name' => 'Наименование не может быть пустым.',
        'invalid_product_data_discount' => 'Скидка должна быть цифрой от 0 до 100.',
        'invalid_product_data_real_price' => 'Розничная цена должна быть числом больше 1.',
    ],
    'fake_section' => 'Нераспределенная продукция',
];
