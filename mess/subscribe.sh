#运行该命令，在２３７的ｗｏｒｄｐｒｅｓｓ插件上注册２３６订阅者。
curl "http://219.223.222.237/?pushpress=hub&hub_mode=subscribe&hub_callback=http://219.223.222.236:8080/androidpn/notification.do?action=pubsub&hub_topic=http://219.223.222.237/feed/atom/&hub_verify=123"

