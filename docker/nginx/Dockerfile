# Dockerfile для Nginx
FROM nginx:alpine

# Копируем только конфиг Nginx
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# EXPOSE по-прежнему нужен для открытого порта
EXPOSE 80
