<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendo Machine</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="card ordering">
            <div class="header">
                <h2>Vendo Machine</h2>
            </div>
            <div class="product-section">
                <p>Products</p>
                <form id="orderForm">
                    <?php
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

                    foreach($arrItems as $key => $value) { ?>
                        <label>
                            <input type="checkbox" name="items[]" value="<?= $key ?>" data-price="<?= $value ?>">
                            <?= $key . ' -  &#8369;' . $value ?>
                        </label><br>
                    <?php } ?>
                    <div class="child">
                        <p>Option</p>
                        <label for="size">Size</label>
                        <select id="size" name="size">
                            <?php foreach($arrSizes as $sizeKey => $sizeValue) { ?>
                                <option value="<?= $sizeKey ?>"><?= $sizeKey != 'Regular' ? $sizeKey . ' (add &#8369; ' . $sizeValue . ')' : $sizeKey; ?></option>
                            <?php } ?>
                        </select>
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1">
                        <button type="submit">Checkout</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card summary">
            <div class="header">
                <h2>Purchase Summary</h2>
            </div>
            <div class="summary-content" id="summaryContent">
                
            </div>
        </div>
    </div>

    <script>
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

            const formData = new FormData(this);
            fetch('process_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const summaryContent = document.getElementById('summaryContent');
                summaryContent.innerHTML = ''; 
                if (data.error) {
                    summaryContent.innerHTML = `<p>${data.error}</p>`;
                } else {
                    data.items.forEach(item => {
                        summaryContent.innerHTML += `<li>${item}</li>`;
                    });
                    summaryContent.innerHTML += `<p>Total Quantity: ${data.totalQuantity}</p>`;
                    summaryContent.innerHTML += `<p>Total Amount: &#8369; ${data.totalAmount}</p>`; 
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
