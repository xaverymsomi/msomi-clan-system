# Msomi Clan Management System

A premium, modern clan management platform designed for the Msomi Clan to preserve heritage, manage membership, and facilitate community contributions.

![Msomi Clan Logo](/public/images/login-bg.jpg)

## 🌟 Key Features

### 🏛️ Cultural Heritage
- **Interactive Family Tree**: Zoomable, interactive visualization of clan lineage using D3.js.
- **Oral History Vault**: Progressive voice recording system for elders to preserve oral traditions directly from mobile devices.
- **Rich Media Gallery**: Support for high-quality images and video archives of clan events and traditions.

### 💳 Financial Management
- **Automated Payment Gateway**: Integrated support for **M-Pesa** and **Flutterwave**.
- **Contribution Tracking**: Real-time tracking of dues, fees, and voluntary contributions.
- **Advanced Reporting**: Generate professional PDF receipts and Excel financial exports.

### 🌐 Modern Ecosystem
- **Progressive Web App (PWA)**: Installable on Android and iOS home screens for a native app-like experience.
- **Global Clan Map**: Interactive geospatial distribution of clan members across Tanzania.
- **Professional Directory**: Searchable expertise network to connect clan members by skills and profession.
- **Global Search**: High-performance search across members, traditions, and financial records.

### 🔒 Security & Identity
- **Audit Logs**: Comprehensive activity tracking for all system changes.
- **Membership ID Cards**: Generation of branded, secure PDF identification cards for members.
- **Role-Based Access Control**: Strict permissions for Admins, Elders, and Members.

## 🚀 Quick Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/msomi-clan-system.git
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
   ```
3. Configuration:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Database & Seeding:
   ```bash
   php artisan migrate --seed
   php artisan db:seed --class=PaymentGatewaySeeder
   ```
5. Start Server:
   ```bash
   php artisan serve
   ```

## 📱 Mobile Installation (PWA)
1. Access the site via **HTTPS**.
2. **Android**: Tap "Add to Home Screen" prompt or select "Install App" from the Chrome menu.
3. **iOS**: Tap the Share button in Safari and select "Add to Home Screen".

## 🛡️ Security
If you discover a security vulnerability, please contact the system administrator.

## 📄 License
This system is custom-built for the Msomi Clan.
