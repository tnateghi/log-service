## About

This project helps you to extract service logs from text file and extract them into database

### Installation and Configuration

##### Execute these commands below, in order

```
1. clone the project
```

```
2. composer install
```

```
3. cp .env-example .env
```

```
4. php artisan key:generate
```

```
5. php artisan migrate
```

#### use this command to insert your logs data from file to database

```
php artisan logs:insert --file=PATH_TO_YOUR_LOG_FILE
```

#### you can test project with this command

```
php artisan test
```
