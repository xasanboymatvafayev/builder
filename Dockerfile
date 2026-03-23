FROM php:8.2-cli

WORKDIR /app
COPY . .

# Server ishga tushadi
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
