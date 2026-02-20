<?php
// СЕКРЕТНЫЙ КЛЮЧ (придумайте сами)
$my_secret_key = "TOP_SECRET_123";

// 1. ОБРАБОТКА УСПЕШНОЙ ОПЛАТЫ (Сюда платежка пришлет уведомление)
if (isset($_GET['payment_success']) && $_GET['key'] === $my_secret_key) {
    $user = htmlspecialchars($_GET['user']);
    $count = htmlspecialchars($_GET['count']);
    
    // ЗАПИСЬ В ВАШ ФАЙЛ (Только после оплаты)
    $log = date('Y-m-d H:i:s') . " | ОПЛАЧЕНО | Юзер: $user | Кол-во: $count | Статус: Запуск накрутки\n";
    file_put_contents('paid_orders.txt', $log, FILE_APPEND);
    
    echo "<h1>Оплата прошла! Накрутка запущена для $user</h1>";
    echo "<a href='/'>Вернуться на сайт</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>TikTok Pay & Boost</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; text-align: center; padding-top: 50px; }
        .box { background: #1e1e1e; padding: 20px; display: inline-block; border-radius: 10px; border: 1px solid #ff0050; }
        input, button { display: block; margin: 10px auto; padding: 12px; width: 280px; border-radius: 5px; border: none; font-size: 16px; }
        input { background: #333; color: white; }
        .price-tag { color: #ff0050; font-size: 20px; font-weight: bold; margin: 10px 0; }
        button { background: #ff0050; color: white; font-weight: bold; cursor: pointer; text-transform: uppercase; }
        button:hover { background: #ff0050; box-shadow: 0 0 15px #ff0050; }
    </style>
</head>
<body>

<div class="box">
    <h2>Накрутка TikTok</h2>
    
    <input type="text" id="tiktok_user" placeholder="@username">
    
    <p>Выберите количество подписчиков:</p>
    <input type="number" id="count" value="100" min="10" oninput="updatePrice()">
    
    <div class="price-tag">К оплате: <span id="total_price">50</span>₽</div>
    
    <button onclick="goToPayment()">Оплатить и запустить</button>
</div>

<script>
    const pricePerOne = 0.5; // Цена за 1 подписчика (например, 50 копеек)

    function updatePrice() {
        const count = document.getElementById('count').value;
        document.getElementById('total_price').innerText = Math.floor(count * pricePerOne);
    }

    function goToPayment() {
        const user = document.getElementById('tiktok_user').value;
        const count = document.getElementById('count').value;
        const price = Math.floor(count * pricePerOne);

        if(!user || user.length < 3) {
            alert("Введите правильный юзернейм!");
            return;
        }

        // В РЕАЛЬНОСТИ: Тут идет переход на сайт платежки (QIWI/LAVA/etc)
        // СЕЙЧАС: Имитируем переход на страницу успешной оплаты
        alert(Перенаправляем на шлюз оплаты... Сумма: ${price} руб.);
        
        // После "оплаты" перекидываем на подтверждение (в реальном API это делает платежка автоматически)
        window.location.href = ?payment_success=1&user=${user}&count=${count}&key=TOP_SECRET_123;
    }
</script>

</body>
</html>
