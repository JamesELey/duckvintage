# Duck Vintage - Laravel Clothing Store CMS

A complete Laravel application for Duck Vintage clothing company featuring a comprehensive CMS (Content Management System) for managing vintage clothing inventory.

## Features

### Frontend
- **Modern Design**: Yellow text on black background theme
- **Product Catalog**: Browse products by category with search and filtering
- **Shopping Cart**: Add products with size and color options
- **User Authentication**: Registration and login system
- **Order Management**: Place and track orders
- **Responsive Design**: Mobile-friendly interface

### Admin CMS
- **Dashboard**: Overview of store statistics and recent orders
- **Product Management**: Full CRUD operations for products
- **Category Management**: Organize products by categories
- **Order Management**: Process and track customer orders
- **User Management**: Manage customer and admin accounts
- **Role-based Access**: Admin and customer roles with permissions

### Technical Features
- **Laravel 10**: Modern PHP framework
- **MySQL Database**: Relational database with proper migrations
- **Spatie Permissions**: Role and permission management
- **File Storage**: Image upload and management
- **Shopping Cart**: Session-based cart functionality
- **Order Processing**: Complete order workflow

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd DuckVintage
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=duck_vintage
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Admin Account

After running the seeders, you can login with:
- **Email**: admin@duckvintage.com
- **Password**: password

## Default Customer Account

- **Email**: customer@example.com
- **Password**: password

## File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin controllers
│   ├── CartController.php
│   ├── OrderController.php
│   ├── ProductController.php
│   └── ...
├── Models/             # Eloquent models
└── Providers/          # Service providers

database/
├── migrations/         # Database migrations
└── seeders/           # Database seeders

resources/
└── views/
    ├── admin/         # Admin views
    ├── auth/          # Authentication views
    ├── layouts/        # Layout templates
    └── ...

routes/
├── web.php            # Web routes
└── api.php            # API routes
```

## Key Models

- **User**: Customer and admin accounts
- **Product**: Clothing items with images, sizes, colors
- **Category**: Product categorization
- **CartItem**: Shopping cart items
- **Order**: Customer orders
- **OrderItem**: Individual items in orders

## Admin Features

### Dashboard
- Store statistics overview
- Recent orders display
- Quick action buttons
- Pending orders counter

### Product Management
- Add/edit/delete products
- Upload multiple images
- Set sizes and colors
- Manage stock quantities
- Featured product toggle
- Price management with sale prices

### Category Management
- Create/edit/delete categories
- Category image upload
- Active/inactive status

### Order Management
- View all orders
- Update order status
- Order details with items
- Customer information

### User Management
- Create/edit/delete users
- Assign roles and permissions
- Password management

## Frontend Features

### Product Catalog
- Browse all products
- Filter by category
- Search functionality
- Product details with images
- Size and color selection

### Shopping Cart
- Add products to cart
- Update quantities
- Remove items
- Size and color options
- Order summary

### Checkout Process
- Shipping address form
- Billing address form
- Order notes
- Order confirmation

### User Account
- Profile management
- Order history
- Order tracking

## Customization

### Theme Colors
The application uses a yellow-on-black theme. To customize:
- Edit `resources/views/layouts/app.blade.php`
- Modify CSS variables in the `<style>` section

### Adding New Features
- Create new controllers in `app/Http/Controllers/`
- Add routes in `routes/web.php`
- Create views in `resources/views/`
- Update models as needed

## Security Features

- CSRF protection
- SQL injection prevention
- XSS protection
- Role-based access control
- Password hashing
- Input validation

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support or questions, please contact the development team or create an issue in the repository.


