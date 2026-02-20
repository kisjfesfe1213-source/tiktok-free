export default async function handler(req, res) {
    if (req.method !== 'POST') return res.status(405).json({ error: 'Method not allowed' });

    const { nickname, count } = req.body;
    const API_KEY = process.env.CASPER_API_KEY; // Твой ключ из настроек Vercel
    const SERVICE_ID = "170"; // ЗАМЕНИ ЭТО на ID услуги из Casper (например 154)

    const url = https://caspersmm.com/api/v2?action=add&key=${API_KEY}&service=${SERVICE_ID}&link=https://www.tiktok.com/@${nickname}&quantity=${count};

    try {
        const response = await fetch(url);
        const data = await response.json();
        res.status(200).json(data);
    } catch (e) {
        res.status(500).json({ error: "Ошибка соединения с Casper" });
    }
}
