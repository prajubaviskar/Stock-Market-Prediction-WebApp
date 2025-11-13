<?php
$ticker = $_GET['ticker'] ?? 'WIPRO.NS';
$date = $_GET['date'] ?? date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $ticker; ?> - Stock Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.1.0"></script>
  <style>
    body {
      background-image: url('https://images.pexels.com/photos/6781008/pexels-photo-6781008.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      background-attachment: fixed;
      backdrop-filter: blur(2px) brightness(0.9);
      padding: 30px;
    }
    .container {
      background: rgba(255, 255, 255, 1);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .chart-container { position: relative; height: 400px; }
    #spinner { display: none; }
  </style>
</head>
<body>
<div class="container">
  <h2 class="mb-4"><?php echo $ticker; ?> Live Stock Dashboard</h2>
  <div id="stock-info" class="mb-4">Loading current price...</div>
  <div class="chart-container mb-4">
    <canvas id="priceChart"></canvas>
  </div>

  <button class="btn btn-primary mb-3" onclick="toggleLSTMPrediction()">Toggle 30-Day LSTM Prediction</button>
  <div id="spinner" class="mb-3"><div class="spinner-border text-primary" role="status"></div></div>
  <div id="lstm-output"></div>
  <div id="bar-chart-container" class="chart-container"><canvas id="barChart"></canvas></div>
  <button class="btn btn-success mt-3" onclick="exportTable('csv')">Export CSV</button>
  <button class="btn btn-success mt-3" onclick="exportTable('xlsx')">Export Excel</button>
</div>

<script>
const ticker = "<?php echo $ticker; ?>";
const startDateStr = "<?php echo $date; ?>";
let lstmVisible = false;

const outputDiv = document.getElementById("lstm-output");
const spinner = document.getElementById("spinner");

async function loadStockData() {
  try {
    const res = await fetch(`yahoo_proxy.php?ticker=${encodeURIComponent(ticker)}`);
    const json = await res.json();

    if (!json.chart || !json.chart.result || json.chart.result.length === 0) {
      throw new Error("Invalid data from Yahoo API");
    }

    const result = json.chart.result[0];
    const timestamps = result.timestamp || [];
    const quote = result.indicators.quote[0];

    if (!timestamps.length || !quote || !quote.close) {
      throw new Error("Incomplete quote data");
    }

    const closes = quote.close;
    const lastIdx = closes.length - 1;
    const lastClose = closes[lastIdx];
    const lastTime = new Date(timestamps[lastIdx] * 1000).toLocaleString();

    document.getElementById("stock-info").innerHTML = `
      <p><strong>Open:</strong> ₹${quote.open[lastIdx].toFixed(2)}</p>
      <p><strong>High:</strong> ₹${quote.high[lastIdx].toFixed(2)}</p>
      <p><strong>Low:</strong> ₹${quote.low[lastIdx].toFixed(2)}</p>
      <p><strong>Previous Close:</strong> ₹${result.meta.chartPreviousClose}</p>
      <p><strong>Current Price:</strong> ₹${lastClose.toFixed(2)}</p>
      <p><strong>Timestamp:</strong> ${lastTime}</p>
    `;

    const labels = timestamps.map(ts => new Date(ts * 1000).toLocaleDateString());
    new Chart(document.getElementById("priceChart"), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: `${ticker} Closing Price`,
          data: closes,
          borderColor: 'rgba(75, 192, 192, 1)',
          fill: false,
          tension: 0.3
        }]
      },
      options: { responsive: true }
    });
  } catch (err) {
    console.error("Failed to load stock data", err);
    document.getElementById("stock-info").innerText = "❌ Failed to load data.";
  }
}

function renderPrediction(predictions, baseDateStr) {
  const startDate = new Date(baseDateStr);
  let html = '<h5>📈 30-Day Prediction:</h5><table class="table table-bordered" id="predictionTable"><thead><tr><th>Date</th><th>Predicted Price (INR)</th></tr></thead><tbody>';
  predictions.forEach((val, idx) => {
    const futureDate = new Date(startDate);
    futureDate.setDate(startDate.getDate() + idx);
    const formattedDate = futureDate.toLocaleDateString('en-IN', {
      day: '2-digit', month: 'short', year: 'numeric'
    });
    html += `<tr><td>${formattedDate}</td><td>₹${val.toFixed(2)}</td></tr>`;
  });
  html += '</tbody></table>';
  outputDiv.innerHTML = html;

  const grouped = [0, 5, 10, 15, 20, 25].map(i =>
    predictions.slice(i, i + 5).reduce((a, b) => a + b, 0) / 5
  );

  new Chart(document.getElementById("barChart"), {
    type: 'bar',
    data: {
      labels: ['Days 1-5', '6-10', '11-15', '16-20', '21-25', '26-30'],
      datasets: [{
        label: 'Avg Predicted Price',
        data: grouped,
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        borderColor: 'rgba(255, 255, 255, 0.9)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: '#000' } } },
      scales: {
        x: { ticks: { color: '#000' }, grid: { color: 'rgba(0,0,0,0.1)' }},
        y: { ticks: { color: '#000' }, grid: { color: 'rgba(0,0,0,0.1)' }}
      }
    }
  });
}

async function fetchPredictionAndRender() {
  spinner.style.display = "block";
  try {
    const res = await fetch("http://localhost:5000/form", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ ticker, start_date: startDateStr })
    });
    if (!res.ok) throw new Error("Prediction API error");
    const data = await res.json();
    const predictions = data.predictions || data.predicted_prices;
    if (!predictions || predictions.length === 0) {
      outputDiv.innerHTML = "❌ No prediction data received.";
      return;
    }
    renderPrediction(predictions, startDateStr);
    lstmVisible = true;
  } catch (err) {
    outputDiv.innerHTML = "❌ Prediction failed.";
    console.error(err);
  } finally {
    spinner.style.display = "none";
  }
}

async function toggleLSTMPrediction() {
  if (lstmVisible) {
    outputDiv.innerHTML = "";
    document.getElementById("barChart").remove();
    document.getElementById("bar-chart-container").innerHTML = '<canvas id="barChart"></canvas>';
    lstmVisible = false;
  } else {
    await fetchPredictionAndRender();
  }
}

function exportTable(type) {
  const table = document.getElementById("predictionTable");
  if (!table) return;
  const wb = XLSX.utils.table_to_book(table);
  XLSX.writeFile(wb, `LSTM_Prediction.${type}`);
}

loadStockData();
setInterval(loadStockData, 120000);
fetchPredictionAndRender();
</script>
</body>
</html>
