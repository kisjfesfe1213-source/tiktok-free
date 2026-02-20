<?php
// --- НАСТРОЙКИ ВАШЕГО ПОСТАВЩИКА ---
$api_url = "https://сайт-поставщика.com/api/v2"; // Уточните в документации поставщика (обычно заканчивается на /api/v2)
$api_key = "ВАШ_API_КЛЮЧ_ЗДЕСЬ"; // Вставьте сюда ваш ключ
$service_id = "123"; // ID услуги ТикТок Подписчики (узнайте в списке услуг на сайте поставщика)

// 1. ОБРАБОТКА ПОСЛЕ "ОПЛАТЫ"
if (isset($_GET['payment_success'])) {
    $user = htmlspecialchars($_GET['user']);
    $count = (int)$_GET['count'];

    // ОТПРАВЛЯЕМ ЗАПРОС ПОСТАВЩИКУ (АВТОМАТИКА)
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

    // ЗАПИСЫВАЕМ В ЛОГ ДЛЯ ВАС
    $log = date('Y-m-d H:i:s') . " | Юзер: $user | Кол-во: $count | Ответ API: $response\n";
    file_put_contents('automated_orders.txt', $log, FILE_APPEND);

    echo "<h1>Оплата принята! Накрутка для $user запущена автоматически.</h1>";
    echo "<p>Результат системы: " . htmlspecialchars($response) . "</p>";
    echo "<a href='/'>На главную</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>TikTok Auto-Boost</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; text-align: center; padding: 50px; }
        .card { background: #1e1e1e; padding: 30px; border-radius: 15px; display: inline-block; border: 1px solid #ff0050; }
        input, button { display: block; margin: 15px auto; padding: 12px; width: 280px; border-radius: 8px; border: none; }
        button { background: #ff0050; color: white; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

<div class="card">
    <h2>TikTok Авто-Накрутка</h2>
    <input type="text" id="username" placeholder="@username">
    <input type="number" id="quantity" value="100" min="10">
    <button onclick="payAndStart()">ОПЛАТИТЬ И ЗАПУСТИТЬ</button>
</div>

<script>
function payAndStart() {
    const user = document.getElementById('username').value;
    const count = document.getElementById('quantity').value;

    if(!user) return alert("Введите ник!");

    // Имитация перехода на оплату
    alert("Переходим к оплате...");
    
    // После "оплаты" перенаправляем на этот же файл с параметрами
    window.location.href = ?payment_success=1&user=${encodeURIComponent(user)}&count=${count};
}
</script>

</body>
</html>
