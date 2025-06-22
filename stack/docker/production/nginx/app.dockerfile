FROM nginx:1.21-alpine

COPY ./stack/docker/production/nginx/conf.d /etc/nginx/conf.d
COPY ./stack/certs /etc/ssl

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log
