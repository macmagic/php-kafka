FROM alpine:latest

MAINTAINER juan-arroyes

RUN apk update && apk add nginx

COPY ./config/nginx.conf /etc/nginx/
COPY ./config/app.conf /etc/nginx/conf.d/

RUN adduser -D -g '' -G www-data www-data

EXPOSE 80
EXPOSE 443

CMD ["nginx"]