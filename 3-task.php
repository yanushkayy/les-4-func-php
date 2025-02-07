<?php
declare(strict_types=1);

// Объявление констант
const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4;
const OPERATION_COUNT = 5;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Изменить название товара.',
    OPERATION_COUNT => OPERATION_COUNT . '. Изменить количество товара.',
];

$items = [];

function showShoppingList(array $items): void {
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        foreach ($items as $itemName => $quantity) {
            echo "$itemName - $quantity шт." . PHP_EOL;
        }
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}


function getUserOperation(array $operations): int {
    do {
        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $operationNumber = (int) trim(fgets(STDIN));

        echo "Вы выбрали операцию: $operationNumber\n";

        if (!array_key_exists($operationNumber, $operations)) {
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operations));

    return $operationNumber;
}

function addItem(array &$items): void {
    echo "Введите название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));

    echo "Введите количество товара: \n> ";
    $quantity = (int) trim(fgets(STDIN));

    if ($quantity > 0) {
        if (isset($items[$itemName])) {
            $items[$itemName] += $quantity;
        } else {
            $items[$itemName] = $quantity;
        }
        echo "Товар '$itemName' добавлен в список с количеством $quantity." . PHP_EOL;
    } else {
        echo 'Количество товара должно быть положительным числом.' . PHP_EOL;
    }
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

    if (isset($items[$itemName])) {
        unset($items[$itemName]);
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

function editItemName(array &$items): void {
    if (count($items) === 0) {
        echo 'Список покуплк пуст. Невозможно изменить товар.' . PHP_EOL;
        return;
    }

    echo 'Текущий список покупок: ' . PHP_EOL;
    showShoppingList($items);

    echo 'Введите название товара для изменения: ' . PHP_EOL . '>';
    $oldItemName = trim(fgets(STDIN));

    if (isset($items[$oldItemName])) {
        echo 'Введите новое название товара: ' . PHP_EOL . '>';
        $newItemName = trim(fgets(STDIN));

        if (isset($items[$newItemName])) {
            echo "Товар $newItemName уже существует в списке." . PHP_EOL;
        } else {
            $items[$newItemName] = $items[$oldItemName];
            unset($items[$oldItemName]);
            echo "Название товара $oldItemName изменено на $newItemName." . PHP_EOL;
        }
    } else {
        echo "Товар $oldItemName не найден в списке." . PHP_EOL;
    }
}

function addCount(array &$items): void {
    if (count($items) === 0) {
        echo 'Список покупок пуст. Невозможно изменить количество товара.' . PHP_EOL;
        return;
    }

    echo 'Текущий список покупок: ' . PHP_EOL;
    showShoppingList($items);

    echo 'Введите название товара для изменения количества: ' . PHP_EOL . '>';
    $itemName = trim(fgets(STDIN));

    if (isset($items[$itemName])) {
        echo 'Введите новое количество товара: ' . PHP_EOL . '>';
        $newCountItems = (int) trim(fgets(STDIN));

        if ($newCountItems > 0) {
            $items[$itemName] = $newCountItems;
            echo "Количество товара '$itemName' изменено на $newCountItems." . PHP_EOL;
        } else {
            echo "Количество должно быть положительным числом." . PHP_EOL;
        }
    } else {
        echo "Товар '$itemName' не найден в списке." . PHP_EOL;
    }
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

        case OPERATION_EDIT:
            editItemName($items);
            break;
        case OPERATION_COUNT:
            addCount($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
