# Geek Meet

Geek Meet is a web application designed to connect geeks from around the world. Users can sign up, create profiles, and interact with other geeks based on their interests.

## Features

- User registration and authentication
- Profile creation and management
- Connect with other users
- Search and filter users by interests

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/geek-meet.git
    cd geek-meet
    ```

2. Install dependencies:
    ```sh
    composer install
    npm install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```sh
    cp .env.example .env
    ```

4. Generate an application key:
    ```sh
    php artisan key:generate
    ```

5. Run the database migrations:
    ```sh
    php artisan migrate
    ```

6. Start the development server:
    ```sh
    php artisan serve
    ```

## Usage

- Visit `http://localhost:8000` in your web browser.
- Sign up for a new account or log in with an existing one.
- Create and manage your profile.
- Search for other geeks and connect with them.

## Contributing

We welcome contributions from the community! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.