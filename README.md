API template
============

Simple template for API

Software
--------
You need GIT, Docker, and Docker-Compose to run the application.

Installation
------------
Download and install application
using Git:
```bash
$ git clone https://github.com/Mednopers/slim-api-template.git myproject
$ cd myproject
$ make init
```
After executing these commands, the necessary components will be installed and configured.
The web server will start automatically.

Usage
-----
There is no need to configure a virtual host in your web server to access the application.

This command will start application:
```bash
$ cd myproject/
$ make up
```

Now you can access the application in your browser at <http://localhost>.

The Swagger-UI interface is available on <http://localhost/swagger>.

To stop docker containers use the command in terminal:
```bash
$ make down
``` 

Tests
-----

Execute this command to run tests:

```bash
$ cd myproject/
$ make up
$ make api-test
```

Docs
-----

Execute this command to generate docs:

```bash
$ cd myproject/
$ make up
$ make api-docs
```
