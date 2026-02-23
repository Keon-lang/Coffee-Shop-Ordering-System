<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kopi Bonet | Welcome</title>
  <style>
    /* ========== GENERAL ========== */
    body {
      font-family: "Poppins", Arial, sans-serif;
      background-color: #fdfcfb;
      color: #333;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    header {
      background: #fff;
      padding: 40px 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      border-radius: 0 0 20px 20px;
      max-width: 800px;
      margin: 0 auto;
    }

    h1 {
      color: #4b2e05;
      font-size: 2.3rem;
      margin-bottom: 8px;
    }

    .tagline {
      font-style: italic;
      color: #795548;
      margin-bottom: 25px;
      font-size: 1rem;
    }

    /* ========== LOGO ========== */
    .logo {
      width: 160px;
      height: auto;
      margin: 10px 0 25px 0;
      border-radius: 50%;
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
      object-fit: cover;
    }

    /* ========== SOCIAL SECTION ========== */
    .social-container {
      margin: 20px 0;
    }

    .social-container p {
      font-weight: 600;
      color: #444;
      font-size: 1.05rem;
      margin-bottom: 10px;
    }

    .social-links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 12px;
    }

    .social-links a {
      text-decoration: none;
    }

    .social-links img {
      width: 90px;
      height: 90px;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      object-fit: cover;
    }

    .social-links img:hover {
      transform: scale(1.1);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* ========== START BUTTON ========== */
    .btn-start {
      display: inline-block;
      margin-top: 35px;
      padding: 14px 32px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      font-size: 1.2rem;
      border-radius: 10px;
      transition: all 0.3s;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .btn-start:hover {
      background-color: #0056b3;
      transform: translateY(-3px);
    }

    footer {
      margin-top: 40px;
      padding: 15px;
      font-size: 0.9rem;
      color: #777;
    }

    /* ========== MOBILE VIEW ========== */
    @media (max-width: 768px) {
      h1 {
        font-size: 1.8rem;
      }

      .tagline {
        font-size: 0.95rem;
        margin-bottom: 20px;
      }

      .logo {
        width: 130px;
      }

      .social-links img {
        width: 75px;
        height: 75px;
        border-radius: 10px;
      }

      .btn-start {
        width: 80%;
        padding: 12px;
        font-size: 1rem;
      }

      footer {
        font-size: 0.8rem;
      }
    }

    /* ========== VERY SMALL SCREEN ========== */
    @media (max-width: 480px) {
      .btn-start {
        width: 90%;
        font-size: 0.95rem;
      }

      .social-links {
        gap: 8px;
      }

      .social-links img {
        width: 65px;
        height: 65px;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Welcome to Kopi Bonet</h1>
    <p class="tagline">“Dari Hati, Untuk Peminum Kopi Sejati.”</p>

    <img src="logo.png" alt="Kopi Bonet Logo" class="logo">

    <div class="social-container">
      <p>Follow and Locate us on Social Media</p><br>
      <div class="social-links">
        <a href="https://www.instagram.com/kopibonet_/" target="_blank">
          <img src="instaa.jpg" alt="Instagram">
        </a>
        <a href="https://www.tiktok.com/@kopibonet_?_t=ZS-90UkSqJ0CTh&_r=1" target="_blank">
          <img src="tiktokk.jpg" alt="TikTok">
        </a>
        <a href="https://www.google.com/maps/place/KopiBonet/@5.5319817,100.4304696,867m" target="_blank">
          <img src="Mapss.png" alt="Google Maps">
        </a>
      </div>
    </div>

    <a href="Order.php" class="btn-start">Start Order</a>
  </header>

  <footer>
    © 2025 Kopi Bonet. All rights reserved.
  </footer>

</body>
</html>


