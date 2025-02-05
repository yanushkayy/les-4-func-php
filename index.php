<?php

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = []; // покупки хранятся здесь

function showMenuAndGetOperation ($operations, $items) {
    // Проверяем ОС и очищаем экран
    if (strtoupper(PHP_OS) === 'WINNT') {
        system('cls'); // Для Windows
    } else {
        system('clear'); // Для Linux/macOS
    }

    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode("\n", $items) . PHP_EOL; // implode - фцнкция, которая соединяет элементы массива в одну строку
    } else {
        'Ваш список покупок пуст.' . PHP_EOL;
    }

    echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    echo implode("\n", $operations) . PHP_EOL;
    $operationNumber = trim (fgets(STDIN));
    return $operationNumber;

}

function addItemToList(&$items) {
    echo "Введение название товара для добавления в список: \n> ";
    $itemNAme = trim (fgets(STDIN));
    $items[] = $itemNAme;
}

function deleteItemFromList(&$items) {
    echo 'Текущий список покупок: ' . PHP_EOL;
    echo 'Список покупок: ' . PHP_EOL;
    echo implode("\n", $items) . PHP_EOL;

    echo 'Введение название товара для удаления из списка: ' . PHP_EOL;
    $itemNAme = trim (fgets(STDIN));

    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    }

}

function printList ($items) {
    echo 'Ваш список покупок: ' . PHP_EOL;
    echo implode(PHP_EOL, $items) . PHP_EOL;
    echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

do {
    $operationNumber = showMenuAndGetOperation ($operations, $items);

    if (!array_key_exists($operationNumber, $operations)) {
        echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
    }

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItemToList($items);
            break;

        case OPERATION_DELETE:
            deleteItemFromList($items);
            break;

        case OPERATION_PRINT:
            printList ($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;

?>

