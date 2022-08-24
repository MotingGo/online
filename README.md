# yujian-blog

#### 介绍
昱建-博客网站 是在大学里的毕业设计，目前是把项目整理一份。
展示效果：维护中

#### 软件架构
软件架构说明: 主要基于 [fuelphp][1]

#### 安装教程

1. 下载源码：git clone https://gitee.com/moting/yujian-blog
2. 安装依赖：composer update
3. 部署数据：导入数据 /data/blog.sql
4. 修改数据库配置信息：fuel/app/config/development/db.php
   ```
   return array(
       'default' => array(
           'connection'  => array(
               'dsn'        => 'mysql:host=【host】;dbname=【dbname】',
               'username'   => '【username】',
               'password'   => '【password】',
           ),
       ),
   );
   ```

#### 使用说明

1. 前端：<hostname>/index.php
2. 后端：<hostname>/

#### 缺陷
1. 安装自动化【环境检测、数据库部署、文件检测】
2. 前端代码复用
3. 页面优化
4. 功能：用户模块未开发
5. 整体过于简陋
6. 展示功能欠缺

  [1]: https://fuelphp.com
