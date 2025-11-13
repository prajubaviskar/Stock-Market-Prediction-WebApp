
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"><title>WebPage Design</title>
                

<style>
        body {
            font-family: Arial, sans-serif;
            background: url('Stock.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }
        .logo {
            font-size: 2em;
            font-weight: bold;
            color: white;
        }
        .menu ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        .menu ul li a {
            text-decoration: none;
            font-size: 1em;
            color: white;
            transition: color 0.3s ease;
        }
        .menu ul li a:hover {
            color: #007bff;
        }
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .srch {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        } 
        
        .content {
            text-align: center;
            margin: 30px auto;
            color: white;
            max-width: 800px;
        }
        .about-us {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 50px auto;
            width: 70%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
            text-align: center;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 50px;
            max-width: 1200px;
            margin: auto;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
         transform: translateY(-10px); /* Lift up */
         box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Stronger shadow */
        }
        .card h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 1em;
            margin-bottom: 15px;
        }
        .card .btn {
  padding: 10px 15px;
}
    .dashboard {
            background:white;
            padding: 30px;
            margin: 30px auto;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
            text-align: center;
        }
        .dashboard p {
            font-size: 1.5em;
            margin: 15px 0;
        }
 .predict-section {
  background-color: #fff;
  padding: 40px;
  border-radius: 12px;
  max-width: 600px;
  margin: 60px auto;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
  
}

.predict-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.predict-form select,
.predict-form input,
.predict-form button {
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 16px;
}

.predict-form button {
  background-color: #28a745;
  color: white;
  cursor: pointer;
  transition: background 0.3s ease;
  width: fit-content;
  margin: 0 auto;
  padding: 10px 30px;
}

.predict-form button:hover {
  background-color: #218838;
}

/* --- News Section --- */
.predict-section,
.news {
  display: block;
  width: 100%;
  max-width: 900px;
  margin: 40px auto;
  text-align: center;
  padding:20px;
}

.news-row {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  gap: 20px;
}

.news-box {
  flex: 1;
  min-width: 280px;
  max-width: 320px;
  background: #f9f9f9;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.news h2 {
  color: white;
  margin-bottom: 30px;
}
html {
      scroll-behavior: smooth;
    }
</style>
</head>
<body>
    <!-- Navbar -->
<div class="navbar">
        <div class="logo">StOck</div>
        <div class="menu">
            <ul>
                <li><a href="#HOME">HOME</a></li>
                <li><a href="#ABOUT">ABOUT US</a></li>
                <li><a href="#CONTACT">CONTACT</a></li>
                <li><a href="#NEWS">NEWS</a></li>
                <li><a href="#SEARCH">SEARCH</a></li>
            </ul>
        </div>
        <div class="search-bar">
  <form id="companyForm" action="dashboard.php" method="get">
    <input list="companies" name="ticker" id="tickerInput" class="srch" placeholder="Type or select company" required>
    <datalist id="companies">
      <option value="TCS.NS">TCS</option>
      <option value="WIPRO.NS">Wipro</option>
      <option value="HCLTECH.NS">HCL</option>
      <option value="INFY.NS">Infosys</option>
      <option value="ICICIBANK.NS">ICICI Bank</option>
      <option value="HDFCBANK.NS">HDFC Bank</option>
      <option value="COFORGE.NS">Coforge</option>
      <option value="MPHASIS.NS">Mphasis</option>
      <option value="SONATSOFTW.NS">Sonata</option>
      <option value="LTIM.NS">LTI</option>
      <option value="ZENSARTECH.NS">Zensar</option>
      <option value="M&M.NS">Mahindra</option>
    </datalist>
    <button type="submit" class="btn">Search</button>
  </form>
</div>
   <div class="dropdown">
    <a href="login.php" class="btn" style="text-decoration: none;">Login</a>
</div>
<div class="dropdown">
    <a href="register.php" class="btn" style="text-decoration: none;">Register</a>
</div>

        </div>
    </div>

    <div class="content">
        <h1>Stock Market Prediction <br>Using <span>Machine Learning</span></h1>
        <p class="par">Predict Your Stock Price <br>for the next 30 days</p>
        <button class="btn"><a href="register.php"style="color: white; text-decoration: none;">JOIN US</a></button>
    </div>

    <div id="ABOUT" class="about-us">
        <h2>About Us</h2>
        <p>Welcome to StOck, your trusted platform for stock market prediction using cutting-edge machine learning algorithms. Our goal is to provide accurate, real-time predictions for stock prices, empowering investors to make informed decisions. Join us and explore the future of stock market forecasting.</p>
    </div>

<!-- 🌦 30-Day Forecast Section FIRST -->
<section class="predict-section">
  <h2>📅 Get 30-Day Stock Forecast</h2>
  <form action="dashboard.php" method="GET" class="predict-form">
  <label for="ticker">Select Company:</label>
  <select id="ticker" name="ticker" required>
    <option value="">--Choose Company--</option>
    <option value="GOOGL">Google</option>
    <option value="AAPL">Apple</option>
    <option value="NFLX">Netflix</option>
    <option value="TSLA">Tesla</option>
    <option value="IBM">IBM</option>
    <option value="ORCL">Oracle</option>
    <option value="CRM">Salesforce</option>
    <option value="META">Facebook (Meta)</option>  
  </select>

    <label for="date">Enter Today's Date:</label>
    <input type="date" id="date" name="date" required>
    <button type="submit">🔍 Predict</button>
  </form>
</section>

<!-- 🔳 Cards Section SECOND -->
<div class="cards">
   <div class="card"> 
     <h3>Apple Inc.</h3>
     <p><strong>Live Price:</strong> <span id="apple-live">Loading...</span></p>
     <p><strong>Predicted Price (Tomorrow):</strong> <span id="apple-price">Loading...</span></p>
     <a href="dashboard.php?ticker=AAPL&date=<?php echo date('Y-m-d'); ?>" class="btn btn-primary">Details</a>
   </div>

   <div class="card">
     <h3>Amazon.com Inc.</h3>
     <p><strong>Live Price:</strong> <span id="amazon-live">Loading...</span></p>
     <p><strong>Predicted Price (Tomorrow):</strong> <span id="amazon-price">Loading...</span></p>
     <a href="dashboard.php?ticker=AMZN&date=<?php echo date('Y-m-d'); ?>" class="btn btn-primary">Details</a>
   </div>
   <div class="card">
     <h3>Microsoft Corp.</h3>
     <p><strong>Live Price:</strong> <span id="microsoft-live">Loading...</span></p>
     <p><strong>Predicted Price (Tomorrow):</strong> <span id="microsoft-price">Loading...</span></p>
     <a href="dashboard.php?ticker=MSFT&date=<?php echo date('Y-m-d'); ?>" class="btn btn-primary">Details</a>
   </div>

   <div class="card">
     <h3>Google LLC</h3>
     <p><strong>Live Price:</strong> <span id="google-live">Loading...</span></p>
     <p><strong>Predicted Price (Tomorrow):</strong> <span id="google-price">Loading...</span></p>
     <a href="dashboard.php?ticker=GOOGL&date=<?php echo date('Y-m-d'); ?>" class="btn btn-primary">Details</a>
   </div>
</div>

<!-- 📰 News Section LAST -->
<section id="news" class="News">
  <h2>📢 Latest News</h2>
  <div class="news-row">
    <div class="news-box">
      <h3>🍎 Apple Inc.</h3>
      <ul id="news-apple"><li>Loading...</li></ul>
    </div>

    <div class="news-box">
      <h3>🛒 Amazon.com Inc.</h3>
      <ul id="news-amazon"><li>Loading...</li></ul>
    </div>

    <div class="news-box">
      <h3>🖥 Microsoft Corp.</h3>
      <ul id="news-microsoft"><li>Loading...</li></ul>
    </div>

    <div class="news-box">
      <h3>📰 All Companies</h3>
      <ul id="news-all"><li>Loading...</li></ul>
    </div>

  </div>
</section>


<script>
async function loadNews(company, containerId) {
  const container = document.getElementById(containerId);
  container.innerHTML = `<h4>📌 ${company.toUpperCase()}</h4><p>Loading...</p>`;

  try {
    const response = await fetch(`http://127.0.0.1:5000/news/${company}`);
    const data = await response.json();

    // Clear previous content
    container.innerHTML = `<h4>📌 ${data.company}</h4>`;

    if (data.headlines && data.headlines.length > 0) {
      const ul = document.createElement("ul");
      data.headlines.forEach(news => {
        const li = document.createElement("li");
        li.innerHTML = `<a href="${news.url}" target="_blank">${news.title}</a>`;
        ul.appendChild(li);
      });
      container.appendChild(ul);
    } else {
      container.innerHTML += "<p>No headlines found.</p>";
    }

  } catch (error) {
    container.innerHTML += "<p>❌ Failed to load news.</p>";
    console.error("News fetch error:", error);
  }
}

// Call for each company
loadNews("apple", "news-apple");
loadNews("amazon", "news-amazon");
loadNews("microsoft", "news-microsoft");

// ✅ NEW: Universal “All Companies” news call
loadNews("all", "news-all");
</script>

<script>
async function fetchStockData(ticker, liveId, predId) {
  const today = new Date().toISOString().split('T')[0];

  // 🔵 Live Price from Flask
  try {
    const liveRes = await fetch(`http://127.0.0.1:5000/realtime?ticker=${ticker}`);
    const liveData = await liveRes.json();
    console.log("✅ Live Data:", liveData);

    if (liveData.live_price) {
      document.getElementById(liveId).innerText = `₹${liveData.live_price.toFixed(2)}`;
    } else {
      document.getElementById(liveId).innerText = 'N/A';
    }
  } catch (err) {
    console.error("❌ Live price fetch failed:", err);
    document.getElementById(liveId).innerText = 'N/A';
  }

  // 🔴 Prediction from Flask
  try {
    const predRes = await fetch("http://127.0.0.1:5000/form", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        start_date: today,
        ticker: ticker
      })
    });

    const predData = await predRes.json();
    console.log("✅ Prediction Data:", predData);

    const predictedPrice = predData.predicted_prices?.[0]; // ✅ Fixed
    if (predictedPrice) {
      document.getElementById(predId).innerText = `₹${predictedPrice.toFixed(2)}`;
    } else {
      document.getElementById(predId).innerText = 'N/A';
    }
  } catch (err) {
    console.error("❌ Prediction fetch failed:", err);
    document.getElementById(predId).innerText = 'N/A';
  }
}
  window.onload = function () {
    fetchStockData('AAPL', 'apple-live', 'apple-price');
    fetchStockData('AMZN', 'amazon-live', 'amazon-price');
    fetchStockData('MSFT', 'microsoft-live', 'microsoft-price');
    fetchStockData('GOOGL', 'google-live', 'google-price');
  };


</script>
<!-- Contact Section -->
<section id ="contact">
<footer style="background-color: #f8f9fa; padding: 30px; text-align: center; margin-top: 50px;">
  <h3>Contact Us</h3>
  <p><strong>Email:</strong> support@stockforecast.com</p>
  <p><strong>Phone:</strong> +91-9422753741</p>
  <p><strong>Address:</strong> SVKM IOT Dhule, India</p>
  <p style="font-size: 14px; color: gray;">© 2025 Stock Forecast. All rights reserved.</p>
</footer>
</section>
</body>