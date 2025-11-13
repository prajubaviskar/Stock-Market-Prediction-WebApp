from flask import Flask, request, jsonify
from flask_cors import CORS
from datetime import datetime, timedelta
import numpy as np
import pandas as pd
from sklearn.preprocessing import MinMaxScaler
from tensorflow.keras.models import load_model
import yfinance as yf
import os
import requests



app = Flask(__name__)
CORS(app)

# ✅ Real-time stock data
@app.route('/realtime', methods=['GET'])
def get_realtime_data():
    ticker = request.args.get('ticker')
    try:
        if not ticker:
            raise ValueError("Ticker is required")

        stock = yf.Ticker(ticker)
        todays_data = stock.history(period="1d", interval="1m")

        if todays_data.empty:
            raise ValueError("No data available for today")

        latest = todays_data.iloc[-1]
        live_price = round(latest['Close'], 2)
        open_price = round(latest['Open'], 2)
        high_price = round(latest['High'], 2)
        low_price = round(latest['Low'], 2)
        prev_close = round(stock.info.get('previousClose', 0), 2)
        time_stamp = latest.name.strftime("%Y-%m-%d %H:%M:%S")

        return jsonify({
            "live_price": live_price,
            "open": open_price,
            "high": high_price,
            "low": low_price,
            "previous_close": prev_close,
            "timestamp": time_stamp
        })

    except Exception as e:
        print("❌ Error in /realtime:", str(e))
        return jsonify({"error": str(e)}), 500

@app.route('/form', methods=['POST'])
def form():
    if request.method == 'OPTIONS':
        response = jsonify({'message': 'CORS preflight success'})
        response.headers.add("Access-Control-Allow-Origin", "*")
        response.headers.add("Access-Control-Allow-Headers", "Content-Type")
        response.headers.add("Access-Control-Allow-Methods", "POST, OPTIONS")
        return response

    try:
        data = request.get_json()
        print("📦 Received data:", data)

        ticker = data.get('ticker')
        start_date_str = data.get('start_date')

        if not ticker or not start_date_str:
            raise ValueError("Ticker and start_date are required.")

        # 🗓️ Parse input date from string
        start_date = datetime.strptime(start_date_str, '%Y-%m-%d')

        # ✅ Load model
        model_path = f"{ticker}_model.h5"
        if not os.path.exists(model_path):
            raise FileNotFoundError(f"Model file not found: {model_path}")
        model = load_model(model_path)

        # ✅ Download historical data
        df = yf.download(ticker, start="2010-01-01", end=start_date_str)
        if df.empty:
            raise ValueError("Stock data is empty. Check ticker and date.")

        close_data = df[['Close']].dropna()
        if len(close_data) < 60:
            raise ValueError("Not enough data to make prediction (need at least 60 closing prices).")

        scaler = MinMaxScaler()
        scaled_data = scaler.fit_transform(close_data)

        last_60 = scaled_data[-60:]
        input_seq = np.array(last_60).reshape(1, 60, 1)

        # 🔮 Predict next 30 days
        predictions = []
        for _ in range(30):
            pred = model.predict(input_seq, verbose=0)[0][0]
            predictions.append(pred)
            input_seq = np.append(input_seq[:, 1:, :], [[[pred]]], axis=1)

        predictions = scaler.inverse_transform(np.array(predictions).reshape(-1, 1)).flatten()
        predictions = [float(p) for p in predictions]

        # 🗓️ Generate prediction dates based on input start_date
        prediction_dates = [
            (start_date + timedelta(days=i)).strftime('%d %b %Y') for i in range(30)
        ]

        print("✅ Prediction with date mapping successful.")
        return jsonify({
            "predicted_dates": prediction_dates,
            "predicted_prices": predictions
        })

    except Exception as e:
        print("❌ Error during prediction:", str(e))
        return jsonify({"error": str(e)}), 500

# ✅ News API route
API_KEY = 'cd543e99c3b54b28bec189ea90a5799d'
BASE_URL = 'https://newsapi.org/v2/everything'

COMPANIES = {
    'apple': 'Apple Inc.',
    'amazon': 'Amazon.com Inc.',
    'microsoft': 'Microsoft Corporation'
}

@app.route('/news/<company>', methods=['GET'])
def get_news(company):
    if company.lower() not in COMPANIES:
        return jsonify({'error': 'Company not found'}), 404

    query = COMPANIES[company.lower()]
    url = f"{BASE_URL}?q={query}&apiKey={API_KEY}&pageSize=5&sortBy=publishedAt&language=en"
    response = requests.get(url)
    data = response.json()

    if response.status_code != 200 or data.get('status') != 'ok':
        return jsonify({'error': 'Failed to fetch news'}), 500

    headlines = [
        {'title': article['title'], 'url': article['url']}
        for article in data.get('articles', [])
    ]
    return jsonify({'company': query, 'headlines': headlines})
@app.route('/news/all', methods=['GET'])
def get_all_news():
    keywords = ["Apple", "Amazon", "Microsoft", "Google", "Infosys", "Wipro", "TCS", "ICICI", "HDFC", "Mphasis"]
    query = " OR ".join(keywords)
    url = f"{BASE_URL}?q={query}&apiKey={API_KEY}&pageSize=5&sortBy=publishedAt&language=en"

    response = requests.get(url)
    data = response.json()

    if response.status_code != 200 or data.get('status') != 'ok':
        return jsonify({'error': 'Failed to fetch news'}), 500

    headlines = [{'title': a['title'], 'url': a['url']} for a in data.get('articles', [])]
    return jsonify({'company': 'All Companies', 'headlines': headlines})



# ✅ Main entry
if __name__ == '__main__':
    app.run(debug=True)
