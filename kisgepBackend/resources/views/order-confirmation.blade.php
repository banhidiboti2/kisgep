<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rendelés visszaigazolás</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #f7f7f7;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #ddd;
        }
        .order-id {
            font-size: 24px;
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rendelés visszaigazolás</h1>
    </div>
    
    <div class="content">
        <p>Tisztelt Ügyfelünk!</p>
        
        <p>Köszönjük rendelését! Az Ön rendelésének azonosítója:</p>
        
        <div class="order-id">{{ $rendeles->rendeles_azonosito }}</div>
        
        <p>Rendelésének adatai:</p>
        <ul>
            <li>Rendelés dátuma: {{ $rendeles->created_at->format('Y-m-d H:i') }}</li>
            <li>Végösszeg: {{ number_format($rendeles->teljes_osszeg, 0, ',', ' ') }} Ft</li>
            <li>Állapot: {{ $rendeles->statusz }}</li>
        </ul>
        
        <p>A rendelés feldolgozása folyamatban van. Munkatársaink hamarosan felveszik Önnel a kapcsolatot.</p>
        
        <p>Üdvözlettel,<br>
        KisGép Kölcsönző Csapata</p>
    </div>
    
    <div class="footer">
        <p>Ez egy automatikusan küldött e-mail, kérjük, ne válaszoljon rá.</p>
        <p>&copy; {{ date('Y') }} KisGép Kölcsönző - Minden jog fenntartva.</p>
    </div>
</body>
</html>