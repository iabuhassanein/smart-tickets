FROM nginx:1.21

COPY ./stack/docker/development/nginx/conf.d /etc/nginx/conf.d

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log
