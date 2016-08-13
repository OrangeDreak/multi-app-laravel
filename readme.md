# laravel 4 多站点配置脚手架。

# 特点

- 支持多站点。 新增站点只要将apps下面的www目录复制一份即可

- 每个站点可以用共用外层models。


# 使用
```
git clone https://github.com/kyo4311/multi-app-laravel.git
```

# 外部共用扩展

- 每个站点目录都有\start\global.php，打开进行修改
```php
ClassLoader::addDirectories(array(

    app_path().'/commands',
    app_path().'/controllers',
    app_path().'/database/seeds',

    base_path().'/services',
    base_path().'/models' //本例子已经扩展的

));
```