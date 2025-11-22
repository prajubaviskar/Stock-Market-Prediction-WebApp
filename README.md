# 📈 Stock Market Price Prediction Web App using LSTM

### 📘 Project Overview
This project predicts the next 30 days of stock prices using an LSTM-based machine learning model.  
It integrates **Flask (Python)** for backend predictions and **PHP (XAMPP)** for a dynamic web dashboard.  
The app displays real-time stock data, predictive graphs, and price trends for multiple companies.

### 🧰 Tools & Technologies
- Python (Flask, TensorFlow, Pandas, NumPy)
- PHP (XAMPP Localhost)
- Chart.js (Interactive Visualization)
- Yahoo Finance API
- HTML, CSS, JavaScript

### 📊 Key Features
- Predicts next 30-day stock prices using LSTM  
- Real-time stock updates using Yahoo Finance  
- Integrated Flask + PHP architecture  
- Interactive dashboard visualization using Chart.js  
- Supports multiple company models (HCL, TCS, ICICI, etc.)

### 📁 Repository Files
- `app.py` – Flask backend for ML predictions  
- `companies.py` – Handles multiple company models  
- `dashboard.php` – Main dashboard interface  
- `yahoo_proxy.php` – Fetches live data from Yahoo Finance  
- `home.php` – Homepage for user navigation  
- `models/` – Contains saved LSTM model files (`.h5`)  
- `static/` – CSS, JS, and frontend assets  
- `templates/` – HTML templates (if any)

### ⚙️ How to Run the Project
1. Install **XAMPP** and start Apache server.  
2. Place the project folder in:
C:\xampp\htdocs\Main\User\
3. Open terminal and install required Python libraries:
pip install flask tensorflow pandas numpy yfinance
4. Start the Flask server:
python app.py
5. Open your browser and visit:http://localhost/Main/User/
🌐 Output

Real-time stock info and 30-day LSTM prediction chart

Dynamic dashboard powered by Flask + PHP integration

👩‍💻 Author

Prajakta Naval Baviskar
Aspiring Data Analyst | Python | Power BI | SQL

https://www.linkedin.com/in/prajubaviskar1124b028b/
