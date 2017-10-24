CURRENT=`php cli migrate version|grep database|awk '{ print $2 }'`
LATEST=`php cli migrate version|grep latest|awk '{ print $2 }'`

# To be executed immediately after cloning the repo
# Sets git shared hooks, grants full permissions to cache and logs folders and
# enables setgid in parent folder to mantain permissions in files under new potential
# folders
init:
	git config core.hooksPath .githooks
	chmod 777 application/cache application/logs
	chmod g+s ./
