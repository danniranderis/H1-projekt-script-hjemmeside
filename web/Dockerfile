###
#
# Dockerfile for the web-service
#
# https://hub.docker.com/_/php/
# Lang-support: https://stackoverflow.com/a/38553499
###

FROM php:7.0-apache
COPY src/ /var/www/html/

# Install and set danish as language in LC_ALL
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    locales
RUN sed -i -e 's/# da_DK.UTF-8 UTF-8/da_DK.UTF-8 UTF-8/' /etc/locale.gen && \
    dpkg-reconfigure --frontend=noninteractive locales && \
    update-locale LANG=da_DK.UTF-8
ENV LC_ALL da_DK.UTF-8