<?php
// --- НАСТРОЙКИ ---
$price_per_one = 0.1; // Цена за 1 подписчика (10 шт = 1 грн, значит 1 шт = 0.1 грн)
$min_order = 5;       // Минимальный заказ
$api_key = "ВАШ_API_КЛЮЧ"; 
$service_id = "123";  
$api_url = "https://сайт-поставщика.com/api/v2";

// ОБРАБОТКА ЗАКАЗА ПОСЛЕ "ОПЛАТЫ"
if (isset($_GET['payment_success'])) {
    $user = htmlspecialchars($_GET['user']);
    $count = (int)$_GET['count'];

    if ($count < $min_order) {
        die("Ошибка: минимальный заказ - $min_order");
    }

    // Авто-запрос к вашему поставщику
    $post_data = [
        'key' => $api_key,
        'action' => 'add',
        'service' => $service_id,
        'link' => 'https://www.tiktok.com/@' . $user,
        'quantity' => $count
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    $response = curl_exec($ch);
    curl_close($ch);

    // Запись в лог заказов
    $total_paid = $count * $price_per_one;
    $log = date('Y-m-d H:i:s') . " | Юзер: $user | Кол-во: $count | Оплачено: $total_paid грн. | Ответ API: $response\n";
    file_put_contents('automated_orders.txt', $log, FILE_APPEND);

    echo "<body style='background:#121212;color:white;text-align:center;padding-top:100px;font-family:sans-serif;'>";
    echo "<h1>Оплата принята!</h1>";
    echo "<p>Заказано $count подписчиков для <b>$user</b>. Сумма: $total_paid грн.</p>";
    echo "<br><a href='/' style='color:#ff0050;'>Вернуться назад</a>";
    echo "</body>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>TikTok Boost - Гривны</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; text-align: center; padding-top: 50px; }
        .card { background: #1e1e1e; padding: 25px; border-radius: 15px; display: inline-block; border: 2px solid #0057b7; width: 320px; }
        input { display: block; margin: 10px auto; padding: 12px; width: 90%; border-radius: 8px; border: none; background: #333; color: white; font-size: 16px; }
        .info { margin: 15px 0; font-size: 14px; color: #bbb; }
        .price-box { font-size: 24px; font-weight: bold; color: #ffd700; margin-bottom: 20px; }
        button { width: 100%; padding: 15px; background: #0057b7; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 16px; transition: 0.3s; }
        button:hover { background: #004494; box-shadow: 0 0 10px #0057b7; }
        button:disabled { background: #555; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="card">
    <h2 style="color: #ffd700;">TikTok Накрутка</h2>
    
    <input type="text" id="username" placeholder="@username у TikTok">
    
    <div class="info">Вартість: 10 підп. = 1 грн</div>
    
    <label>Кількість (мін. <?php echo $min_order; ?>):</label>
    <input type="number" id="quantity" value="10" min="<?php echo $min_order; ?>" oninput="calculate()">

    <div class="price-box">До сплати: <span id="total">1.00</span> грн</div>
    
    <button id="payBtn" onclick="processPayment()">ОПЛАТИТИ В ГРН</button>
</div>

<script>
    const pricePerOne = <?php echo $price_per_one; ?>;
    const minOrder = <?php echo $min_order; ?>;

    function calculate() {
        const qty = document.getElementById('quantity').value;
        const totalSpan = document.getElementById('total');
        const btn = document.getElementById('payBtn');

        if (qty < minOrder) {
            totalSpan.innerText = "0";
            btn.disabled = true;
            btn.innerText = "Мін. замовлення: " + minOrder;
        } else {
            totalSpan.innerText = (qty * pricePerOne).toFixed(2);
            btn.disabled = false;
            btn.innerText = "ОПЛАТИТИ В ГРН";
        }
    }
function processPayment() {
        const user = document.getElementById('username').value;
        const qty = document.getElementById('quantity').value;
        
        if (!user || user.length < 3) return alert("Введіть нік TikTok!");

        alert("Перенаправлення на оплату в гривнях...");
        // Імітація успішної оплати
        window.location.href = ?payment_success=1&user=${encodeURIComponent(user)}&count=${qty};
    }
</script>

</body>
</html>
