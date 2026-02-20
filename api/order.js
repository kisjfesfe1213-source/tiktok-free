export default async function handler(req, res) {
    if (req.method !== 'POST') return res.status(405).json({ error: 'Метод не разрешен' });

    const { nickname, amount } = req.body;
    const API_KEY = process.env.CASPER_API_KEY; 
    const SERVICE_ID = "154"; // Поставь тут ID своей услуги из Casper

    // URL для запроса к Casper SMM
    const url = https://caspersmm.com/api/v2?action=add&key=${API_KEY}&service=${SERVICE_ID}&link=https://www.tiktok.com/@${nickname}&quantity=${amount};

    try {
        const response = await fetch(url);
        const data = await response.json();
        res.status(200).json(data);
    } catch (e) {
        res.status(500).json({ error: "Ошибка связи с сервером накрутки" });
    }
}
