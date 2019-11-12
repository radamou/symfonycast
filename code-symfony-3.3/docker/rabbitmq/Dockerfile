FROM rabbitmq:3.7-management-alpine

RUN wget -O /tmp/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip  https://dl.bintray.com/rabbitmq/community-plugins/3.7.x/rabbitmq_delayed_message_exchange/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip
RUN unzip /tmp/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip -d /opt/rabbitmq/plugins/
RUN rabbitmq-plugins enable rabbitmq_delayed_message_exchange
RUN rm /tmp/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip
