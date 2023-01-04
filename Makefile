install:
	.docker/composer.sh composer install

rabbitmq-install:
	# 1
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare queue name=requests_queue
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare exchange name=requests_exchange type=direct
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare binding source=requests_exchange destination=requests_queue
	# 2
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare queue name=telegram_notifications_queue
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare exchange name=telegram_exchange type=direct
	.docker/rabbitmq.sh rabbitmqadmin -urmuser -prmpassword declare binding source=telegram_exchange destination=telegram_notifications_queue
