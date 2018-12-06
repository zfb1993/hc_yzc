#!/bin/bash

count=`ps -ef |grep "index.php" | grep -v "grep" | wc -l`
echo $count

if [ $count > 1 ]
then
	`ps -ef |grep index.php |awk '{print $2}' |xargs kill -9`
	sleep 3
	/usr/bin/php /home/wwwdata/wwwroot/cqh.1caopan.com/public/index.php qihuo/Hqingsocket/startup
	/usr/bin/php /home/wwwdata/wwwroot/cqh.1caopan.com/public/index.php qihuo/Tradesocket/startup
else
	echo "count 等于 $count"
fi

echo $(date +%Y-%m-%d_%H:%M:%S) >>/home/wwwdata/wwwroot/cqh.1caopan.com/public/restart.log

