# 🌤️ Laravel Weather API

This is a Laravel-based backend service that fetches real-time and hourly forecast weather data using the [Open-Meteo API](https://open-meteo.com/en/docs). It returns a clean, chart-ready JSON response using Laravel's API Resource system.

---

## 🚀 Features

- ✅ Real-time current weather
- ✅ Hourly forecast (temperature, humidity, wind, etc.)
- ✅ Weather codes (numeric)
- ✅ Laravel API Resource response
- ✅ Caching results for 10 minutes per location
- ✅ Clean Laravel structure (Controllers + Services + Resources)

---

## 📂 Project Structure

- `app/Http/Controllers/WeatherController.php` — Handles API requests
- `app/Services/WeatherService.php` — Talks to Open-Meteo API
- `app/Http/Resources/WeatherResource.php` — Formats the response
- `routes/api.php` — Registers the `/api/weather` route

---

## 🛠️ Installation

```bash
git clone https://github.com/YOUR_USERNAME/laravel-weather-api.git
cd laravel-weather-api

# Set up environment
cp .env.example .env
composer install
php artisan key:generate

# Start local dev server
php artisan serve
