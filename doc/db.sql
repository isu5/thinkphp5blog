create table tp5_category(
id int unsigned not null primary key auto_increment,
pid int unsigned not null default 0 comment '父id',
catename varchar(30) not null default '' comment '栏目名称',
seo_keyword varchar(80) not null default '' comment '关键词',
seo_desc varchar(120) not null default '' comment '描述',
thumb varchar(200) not null default '' comment '缩略图',
addtime int not null comment '添加时间'
)engine=innodb charset=utf8 comment="栏目表";

create table tp5_artile(
id int unsigned not null primary key auto_increment,
cid int unsigned not null default 0 comment '栏目id',
tid int unsigned not null default 0 comment '标签id',
title varchar(200) not null default '' comment '文章标题',
thumb varchar(200) not null default '' comment '缩略图',
content text,
sort int unsigned not null default 0 comment '排序',
addtime int unsigned comment '添加时间'
)engine=innodb charset=utf8 comment '文章表',