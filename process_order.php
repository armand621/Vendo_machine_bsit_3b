<?php
header('Content-Type: application/json'); // Set the content type for JSON response

$arrItems = array(
    "Coke" => 15,
    "Sprite" => 20,
    "Royal" => 20,
    "Pepsi" => 15,
    "Mountain Dew" => 20,
);

$arrSizes = array(
    "Regular" => 0,
    "Up-Size" => 5,
    "Jumbo" => 10
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedItems = isset($_POST['items']) ? $_POST['items'] : [];
    $size = isset($_POST['size']) ? $_POST['size'] : 'Regular';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Default to 1 if not set

    $totalAmount = 0;
    $totalQuantity = 0;
    $itemsList = [];

    if (empty($selectedItems)) {
        echo json_encode(['error' => 'No selected product, try again.']);
        exit;
    }

    foreach ($selectedItems as $item) {
        if (array_key_exists($item, $arrItems)) {
            $itemPrice = $arrItems[$item] + $arrSizes[$size]; // Get item price and add size price
            $totalAmount += $itemPrice * $quantity;
            $totalQuantity += $quantity;

            // Format item entry in the summary
            $itemsList[] = "{$quantity} piece(s) of {$size} {$item} amounting &#8369; " . number_format(($itemPrice * $quantity), 2);
        }
    }

    // Create response array
    $response = [
        'items' => $itemsList,
        'totalQuantity' => $totalQuantity,
        'totalAmount' => number_format($totalAmount, 2) // Format total amount to 2 decimal places
    ];

    echo json_encode($response);
    exit;
}
?>
