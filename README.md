# 🐝 EventHive

> **A modern, vibrant event management platform for everyone!**

EventHive is a modern event management platform built with PHP and MySQL. It enables users to discover, register, and participate in events, while providing admins with tools to manage events, view analytics, and monitor participation.



## ✨ Features

- 🔐 **User Registration & Login:** Secure sign up and login for users and admins
- 🏠 **Role-Based Dashboards:** Separate dashboards for users and admins
- 🔍 **Event Discovery:** Browse, search, and view details of upcoming events
- 📝 **Easy Registration:** Register for events with a single click
- 🏆 **Leaderboard:** Track participant rankings based on event scores
- 👤 **Profile Management:** Users can view and update their profiles
- 🛠️ **Admin Tools:** Event creation, participant management, and analytics
- 📱 **Responsive UI:** Clean, mobile-friendly design using Tailwind CSS

---

## 🗂️ Project Structure

```
EventHive/
├── admin/           # 🛠️ Admin dashboard and tools
├── assets/          # 🎨 CSS, JS, images
├── operations/      # ⚙️ PHP scripts for DB, login, registration
├── user/            # 👤 User dashboard and features
├── eventhive.sql    # 🗄️ Database schema
├── header.php       # 🏷️ Shared site header
├── login.php        # 🔐 Login and registration page
├── logout.php       # 🚪 Logout script
└── README.md        # 📖 Project documentation
```

---

## 🚀 Setup Instructions

1. **Clone the Repository:**
   ```bash
   git clone <your-repo-url>
   ```
2. **Database Setup:**
   - 📥 Import `eventhive.sql` into your MySQL server
   - 📝 Update `operations/db_connection.php` with your DB credentials
3. **Run Locally:**
   - 📂 Place the project in your XAMPP `htdocs` directory
   - ▶️ Start Apache and MySQL via XAMPP Control Panel
   - 🌐 Access the app at [`http://localhost/EventHive/login.php`](http://localhost/EventHive/login.php)

---

## 🧑‍💻 Default Credentials (Sample Data)
- 👤 **User:** `hari` / `hari`
- 🛡️ **Admin:** `faculty1` / `faculty1`

---

## 📦 Dependencies
- 🐘 PHP 8+
- 🐬 MySQL/MariaDB
- 🎨 Tailwind CSS (via CDN)
- 📊 Chart.js (for dashboards)

---

## 🔒 Security Notes
- User sessions are required for all dashboard and sensitive pages
- ⚠️ Passwords in the sample data are stored in plain text for demonstration. **Change this for production!**

---

## 🤝 Contribution
Pull requests and suggestions are welcome!

---

## 📄 License
MIT License

---

### 🐝 EventHive – *Simplifying Event Management for All!*
