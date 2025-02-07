<?php
declare(strict_types=1);

// Объявление констант
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

$items = [];

function showShoppingList(array $items): void {
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode("\n", $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}

function getUserOperation(array $operations): int {
    do {
        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $operationNumber = (int) trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operations)) {
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operations));

    return $operationNumber;
}

function addItem(array &$items): void {
    echo "Введите название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

function deleteItem(array &$items): void {
    if (count($items) === 0) {
        echo 'Список покупок пуст. Невозможно удалить товар.' . PHP_EOL;
        return;
    }

    echo 'Текущий список покупок:' . PHP_EOL;
    showShoppingList($items);

    echo 'Введите название товара для удаления из списка: ' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (($key = array_search($itemName, $items, true)) !== false) {
        unset($items[$key]);
        echo "Товар '$itemName' удален из списка." . PHP_EOL;
    } else {
        echo "Товар '$itemName' не найден в списке." . PHP_EOL;
    }
}

function printShoppingList(array $items): void {
    echo 'Ваш список покупок: ' . PHP_EOL;
    showShoppingList($items);
    echo 'Всего ' . count($items) . ' позиций.' . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

do {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');  // Для Windows
    } else {
        system('clear');  // Для Unix-подобных систем (Linux, macOS)
    }

    showShoppingList($items);

    $operationNumber = getUserOperation($operations);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItem($items);
            break;

        case OPERATION_DELETE:
            deleteItem($items);
            break;

        case OPERATION_PRINT:
            printShoppingList($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
