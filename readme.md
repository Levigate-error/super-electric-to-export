### Requirements

-   docker
-   docker-compose v > 1.23

#### Install

```shell script
$> git clone ssh://git@bitbucket.zebrains.team:7999/legweb/legrand-planner.git
$> cd legrand-planner
$> make env
$> make build
$> make up
$> make prepare-app
```

In `/etc/hosts` set `127.0.0.1 legwebdocker.local`
#### Install исправленный
Run make first-run
#### Settings

##### Port

use docker ps to see web service port.

##### Admin panel

In .env set admin ADMIN_ROUTE_PREFIX.
Admin url: legwebdocker.local:{PORT}/{ADMIN_ROUTE_PREFIX}
Default logo-pas admin -> admin

##### Api documentation

```shell script
$> make apidoc
```

Then your doc url: legwebdocker.local:{PORT}/doc/index.html

#### Update classes

```shell script
$> composer dump-autoload
```

##### XDebug
Manual for XDebug settings in PhpStorm with Docker https://blog.denisbondar.com/post/phpstorm_docker_xdebug