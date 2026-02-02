# 💰 Smart Expense Tracker with AI Insights

> A modern expense management system built with **Laravel** and **Filament PHP**, supercharged by **OpenAI** to provide personalized financial advice.

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-10.x%2F11.x-FF2D20.svg)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3-F2C94C.svg)](https://filamentphp.com)
[![OpenAI](https://img.shields.io/badge/AI-OpenAI%20GPT-412991.svg)](https://openai.com)

## 📖 Overview

This project is not just a typical CRUD application. It is a smart financial assistant that helps users track their expenses and utilizes **Artificial Intelligence** to analyze spending habits. By leveraging the power of **Filament PHP** for a robust admin panel and **OpenAI API** for data analysis, this application turns raw numbers into actionable financial plans.

![Dashboard Screenshot](path/to/your-screenshot.png) 
*(Note: Please replace the link above with a screenshot of your Filament Dashboard)*

## ✨ Key Features

* **🚀 Powered by Filament PHP:** A sleek, responsive, and dark-mode capable dashboard for managing records.
* **🤖 AI Financial Advisor:** Integrated OpenAI to analyze monthly expenses and generate a custom plan to reduce unnecessary spending.
* **📊 Interactive Widgets:** Visual charts and stats (Expenses per category, Monthly trend) provided by Filament Widgets.
* **🔍 Advanced Filtering:** Filter expenses by date, category, or amount using Filament's powerful table builder.
* **📱 Responsive Design:** Fully functional on mobile and desktop.

## 🛠️ Tech Stack

* **Backend Framework:** Laravel (PHP)
* **Admin Panel:** Filament PHP (TALL Stack)
* **AI Integration:** OpenAI API (GPT Model)
* **Database:** MySQL
* **Environment Management:** Dotenv for securing API Keys

## 🧠 How the AI Integration Works

1.  **Data Collection:** The system aggregates the user's expense data for a selected period.
2.  **Prompt Engineering:** A structured prompt is sent to OpenAI, including spending categories and totals (anonymized data).
3.  **Analysis:** The AI analyzes the patterns (e.g., "High spending on dining out").
4.  **Actionable Advice:** The system displays a concrete plan to save money directly on the dashboard.

## 🚀 Installation & Setup

Follow these steps to run the project locally:

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/your-username/your-repo-name.git](https://github.com/your-username/your-repo-name.git)
    cd your-repo-name
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure Database & API Keys:**
    Open the `.env` file and update your database credentials and add your OpenAI Key:
    ```env
    DB_DATABASE=your_db_name
    OPENAI_API_KEY=sk-your-openai-api-key
    ```

5.  **Run Migrations:**
    ```bash
    php artisan migrate
    ```

6.  **Create a Filament User:**
    ```bash
    php artisan make:filament-user
    ```

7.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000/admin` to access the dashboard.

## 🔒 Security Note
This project follows strict security practices. API keys are stored in environment variables and are never exposed to the client-side.

## 🤝 Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

---
**Developed with ❤️ by [Abdalaziz almufti]**
