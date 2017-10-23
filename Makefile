CURRENT=`php cli migrate version|grep database|awk '{ print $2 }'`
LATEST=`php cli migrate version|grep latest|awk '{ print $2 }'`

# To be executed immediately after cloning the repo
# Sets git shared hooks, initializes development DB and seeds it, and grants full permissions
# to cache and logs folders
init:
	git config core.hooksPath .githooks
	php cli migrate `php cli migrate version|grep latest|awk '{ print $2 }'`
	php cli seed
	chmod 777 application/cache application/logs
