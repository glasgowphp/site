#GlasgowPHP

This is a "work in progress" directry of glasgowphp website.

> Please note that [Mizzenlite](https://github.com/strayobject/mizzenlite)
is not even beta. And code here may and will be changed in a way that will
break bc.
> Content of the modules directory will be removed from this repo in the near
future.
> You should have no need to use it at the moment.

###Installation
----

If you insist on installing this locally, clone the repo and do:

```bash
$ cd <folder_name>
$ composer install
$ git submodule init && git submodule update
$ cp config/config.json.sample config/config.json
$ sudo chmod 0777 var
```

This should provide you with a working copy of a glasgowphp website