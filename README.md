 🌤️ Weather Comfort Index Dashboard

A secure full-stack web application that ranks cities by **weather comfort level**, built with **Laravel**, **Auth0 authentication**, and **OpenWeather API**.

 🚀 Features

* 🌍 Fetches real-time weather data from **OpenWeather API**
* 📊 Calculates a **Comfort Index** based on temperature & conditions
* 📈 Displays cities ranked from **most comfortable to least comfortable**
* ⚡ Caching implemented for API efficiency
* 🔐 Secure authentication using **Auth0**
* 🛡️ Email whitelisting & Multi-Factor Authentication (MFA)

 🛠️ Tech Stack

 Backend

* **Laravel 12**
* **PHP 8.2**
* SQLite (local)

 Authentication & Security

* **Auth0**
* Email whitelist enforcement
* MFA (email-based)
* Public signups disabled

 External APIs

* **OpenWeather API**

 📦 Installation & Setup

 1️⃣ Clone the Repository

```bash
git clone <repository-url>
cd weather-comfort-index/backend
```

 2️⃣ Install Dependencies

```bash
composer install
npm install
```

 3️⃣ Environment Configuration

Create a `.env` file from the example:

```bash
cp .env.example .env
```

Update the following values:

```env
APP_URL=http://127.0.0.1:8000

OPENWEATHER_API_KEY=your_openweather_api_key
OPENWEATHER_BASE_URL=https://api.openweathermap.org/data/2.5

AUTH0_DOMAIN=your-tenant.us.auth0.com
AUTH0_CLIENT_ID=your_client_id
AUTH0_CLIENT_SECRET=your_client_secret
AUTH0_REDIRECT_URI=http://127.0.0.1:8000/callback
AUTH0_LOGOUT_REDIRECT_URI=http://127.0.0.1:8000/
```

⚠️ **Never commit `.env` to version control**


 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

 5️⃣ Run Migrations

```bash
php artisan migrate
```

 6️⃣ Start the Application

```bash
php artisan serve
npm run dev
```

Visit:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**


 🔐 Authentication & Security

 Auth0 Configuration

 ✅ Public Signups Disabled

* Signups are disabled at the Auth0 **Database Connection** level.

 ✅ Email Whitelisting

Only the following email is allowed to log in:

```
careers@fidenz.com
```

Enforced using an **Auth0 Post-Login Action**.

 ✅ Multi-Factor Authentication (MFA)

* **Email-based MFA** enabled
* Required during login for enhanced security


 🧠 Comfort Index Logic

The comfort index is calculated using:

* Temperature (°C)
* Weather conditions (clear, clouds, etc.)

Cities are sorted in descending order:

```
Most Comfortable → Least Comfortable
```

 📊 Dashboard View

The dashboard displays:

* City name
* Weather description
* Temperature (°C)
* Comfort Index score
* Rank

Includes a **Refresh** option to update cached data.


 🧪 API & Caching

* Weather responses are cached to reduce API calls
* Cache hit/miss can be verified via debug endpoints


 🗂️ Project Structure (Backend)

backend/
├── app/
│   └── Services/
│       └── OpenWeatherService.php
├── routes/
│   ├── web.php
│   └── api.php
├── resources/
│   └── views/
│       └── dashboard.blade.php
├── storage/
│   └── app/data/cities.json


 🔒 Security Notes

* `.env` excluded from repository
* Secrets stored securely via environment variables
* Auth0 handles authentication and token validation
* MFA and email restrictions enforced at identity level


 ✅ Assignment Requirements Status

| Requirement            | Status      |
| ---------------------- | ----------- |
| Weather dashboard      | ✅ Completed |
| Auth0 authentication   | ✅ Completed |
| Disable public signups | ✅ Completed |
| Whitelist email        | ✅ Completed |
| Enable MFA             | ✅ Completed |
| README documentation   | ✅ Completed |

 👤 Author

**Vorandi Sakithma**
Full Stack Developer
