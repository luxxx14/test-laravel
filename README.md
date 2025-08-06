<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Запуск приложения

1. git clone https://github.com/luxxx14/test-laravel.git .
2. cp .env.example .env (в windowns - скопировать файл .env.example в .env)
3. make up
4. Если требуется добавить тестовые данные - выполнить команду make seed
5. Для генерации описания swagger - выполнить команду make swagger. Документация будет доступна по адресу /api/documentation
6. Приложение будет запущено и доступно на порте 8080
7. При отправке запросов на api необходимо в заголовке X-API-KEY передать api ключ (который прописан в файле .env)

## Остановка приложения
1. make down
