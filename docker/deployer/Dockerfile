FROM php:7.2.23-cli-alpine
RUN apk update --no-cache \
    && apk add --no-cache openssh-client \
    && apk add --no-cache rsync
RUN mkdir -p ~/.ssh && echo StrictHostKeyChecking no >> ~/.ssh/config
