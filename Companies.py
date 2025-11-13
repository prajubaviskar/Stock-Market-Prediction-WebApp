import yfinance as yf
import numpy as np
import pandas as pd
from sklearn.preprocessing import MinMaxScaler
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense
import os

# ✅ Put it here
company_tickers = {
    "TCS": "TCS.NS",
    "WIPRO": "WIPRO.NS",
    "HCL": "HCLTECH.NS",
    "INFY": "INFY.NS",
    "LTI": "LTIM.NS",
    "ICICI": "ICICIBANK.NS",
    "HDFC": "HDFCBANK.NS",
    "MPHASIS": "MPHASIS.NS",
    "COFORGE":"COFORGE.NS",
    "ZENSAR":"ZENSARTECH.NS",
    "SONATA":"SONATSOFTW.NS",
    "Mahindra":"M&M.NS",
    
    "Apple": "AAPL",
    "Amazon": "AMZN",
    "Microsoft": "MSFT",
    "Google": "GOOGL",
    "Netflix":"NFLX",
    "Tesla":"TSLA",
    "Oracle":"ORCL",
    "Salesforce":"CRM",
    "Facebook(Meta)":"META"
}

# ✅ Define the training function
def train_and_save_model(ticker, filename):
    print(f"📈 Training model for {ticker}...")
    df = yf.download(ticker, start="2010-01-01")
    if df.empty or len(df) < 100:
        print(f"❌ No sufficient data for {ticker}")
        return

    data = df[['Close']].dropna()
    scaler = MinMaxScaler()
    scaled_data = scaler.fit_transform(data)

    X, y = [], []
    for i in range(60, len(scaled_data)):
        X.append(scaled_data[i-60:i])
        y.append(scaled_data[i])

    X, y = np.array(X), np.array(y)

    model = Sequential([
        LSTM(50, return_sequences=True, input_shape=(X.shape[1], 1)),
        LSTM(50),
        Dense(1)
    ])
    model.compile(optimizer='adam', loss='mean_squared_error')
    model.fit(X, y, epochs=5, batch_size=32, verbose=0)

    model.save(f"{filename}_model.h5")
    print(f"✅ Saved model: {filename}_model.h5")

# ✅ Loop through and train all
for name, ticker in company_tickers.items():
    model_path = f"{ticker}_model.h5"
    if os.path.exists(model_path):
        print(f"⏩ Skipping {ticker}, model already exists.")
        continue
    try:
        train_and_save_model(ticker, ticker)
    except Exception as e:
        print(f"❌ Failed to train {ticker}: {e}")