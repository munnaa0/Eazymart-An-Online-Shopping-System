# EazyMart - Online Shopping System

EazyMart is a comprehensive web-based e-commerce platform built with PHP and MySQL. It provides a complete online shopping experience with user management, product catalog, shopping cart, order processing, and customer feedback features.

## 🚀 Features

### Core Functionality
- **User Authentication**: Complete registration and login system with secure password hashing
- **Product Management**: Browse and search products with detailed information and images
- **Shopping Cart**: Add, remove, and manage items in your cart
- **Order Processing**: Complete order management from cart to order history
- **Customer Feedback**: Product rating and review system
- **User Profile**: Manage personal information and view order history
- **Inventory Management**: Real-time stock tracking

### User Features
- User registration with personal details (name, address, email, phone)
- Secure login/logout functionality
- Product browsing with categories
- Search functionality
- Shopping cart management
- Order placement and tracking
- Feedback and rating system
- Profile management

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Icons**: Font Awesome 6.0
- **Session Management**: PHP Sessions
- **Password Security**: PHP password_hash() function

## 📋 Prerequisites

Before installing EazyMart, ensure you have the following:

- **Web Server**: Apache or Nginx
- **PHP**: Version 7.4 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.4+
- **Extensions**: 
  - mysqli
  - session support
  - mbstring

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/munnaa0/Eazymart-An-Online-Shopping-System.git
cd Eazymart-An-Online-Shopping-System
```

### 2. Database Setup
1. Create a new MySQL database named `eazymart`
2. Import the database schema:
```sql
mysql -u your_username -p eazymart < eazymart.sql
```

### 3. Configure Database Connection
Edit `connection.php` and update the database credentials:
```php
$dbhost = "localhost";      // Your database host
$dbuser = 'root';           // Your database username  
$dbpass = '';               // Your database password
$dbname = 'eazymart';       // Database name
```

### 4. Web Server Setup
- Place the project files in your web server's document root (e.g., `htdocs` for XAMPP)
- Ensure the web server has read/write permissions to the project directory
- Start your web server and database service

### 5. Access the Application
Open your web browser and navigate to:
```
http://localhost/Eazymart-An-Online-Shopping-System/
```

## 📁 Project Structure

```
EazyMart/
├── Cart/                   # Shopping cart functionality
│   ├── cart.php           # Cart management page
│   └── cart.css           # Cart styling
├── Orders/                # Order management
│   └── orders.php         # Order history and details
├── Products/              # Product catalog
│   ├── products.php       # Product listing page
│   └── products.css       # Product styling
├── Profile/               # User profile management
│   └── profile.php        # User profile page
├── login/                 # Authentication system
│   ├── login.php          # Login page
│   ├── logout.php         # Logout functionality
│   └── login.css          # Login styling
├── registration/          # User registration
│   └── register.php       # Registration page
├── feedback/              # Customer feedback system
│   └── feedback.php       # Feedback form and display
├── images/                # Static assets
│   ├── Eazy.png          # Application logo
│   ├── product images/    # Product images
│   └── other assets/      # Other UI images
├── connection.php         # Database connection config
├── functions.php          # Common PHP functions
├── eazymart.sql          # Database schema and sample data
├── index.php             # Homepage
├── style.css             # Global stylesheet
└── README.md             # This file
```

## 🗄️ Database Schema

The application uses the following main tables:

- **users**: User authentication information
- **person**: Personal information (name, address)
- **personemail**: User email addresses
- **personphone**: User phone numbers
- **product**: Product catalog with details
- **inventory**: Stock management
- **cart**: Shopping cart items
- **orders**: Order information
- **orderitems**: Individual order items
- **feedback**: Customer reviews and ratings

## 🚀 Usage

### For Customers:
1. **Register**: Create a new account with personal details
2. **Login**: Access your account
3. **Browse Products**: View available products on the homepage
4. **Add to Cart**: Select products and add them to your cart
5. **Checkout**: Complete your order
6. **Track Orders**: View order history in your profile
7. **Leave Feedback**: Rate and review products

### For Administrators:
- Manage product inventory through the database
- View customer feedback and orders
- Update product information and stock levels

## 🔒 Security Features

- **Password Hashing**: Uses PHP's `password_hash()` function
- **SQL Injection Prevention**: Uses `mysqli_real_escape_string()`
- **Session Management**: Secure session handling
- **Input Validation**: Form data validation and sanitization

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🐛 Known Issues

- Search functionality is implemented in the UI but may need backend integration
- Payment gateway integration is not included
- Admin panel for product management is not implemented in the UI

## 🔮 Future Enhancements

- Payment gateway integration
- Admin dashboard for product and order management
- Advanced search and filtering
- Email notifications
- Mobile responsive design improvements
- API integration
- Multi-language support

## 📞 Support

For support and questions, please open an issue in the GitHub repository.

## 👥 Authors

- **Munna** - Initial work - [munnaa0](https://github.com/munnaa0)

## 🙏 Acknowledgments

- Font Awesome for icons
- Bootstrap community for styling inspiration
- PHP and MySQL communities for excellent documentation