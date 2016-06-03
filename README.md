#拾影服务器设计

#数据库设计

##user
用户
+ id
+ number
+ password
+ name
+ avatar
+ background
+ gender
+ intro
+ token

##picture
图片
+ id
+ name//图片名称
+ intro//图片简介长度200
+ width
+ height
+ src//图片地址长度200
+ author_id
+ tag//tag名字文本存储，逗号分割
+ score //评分
+ watch_count//查看次数
+ collection_count//收藏次数
+ album_id
+ create_time//创建时间

##album
图片专辑
+ id
+ name
+ avatar
+ author_id
+ intro

##picture_collection
图片收藏关系表
+ id
+ user_id
+ photo_id


##album_collection
专辑收藏关系表
+ id
+ user_id
+ album_id

##tag
标签管理表，记录了每个用户的每个标签得分
+ id
+ name
+ score
+ author_id


##follow
+ id
+ star//被关注者id
+ fans//关注者id


#API设计
header上增加`token`,`UID`2个请求头识别用户。
标准RestfulAPI。状态为HTTP响应头状态
200 正常
info指：{"info":"你随便写些什么，没什么写的写个success"}
400 参数错误
401 未授权 比如没有token，或token失效
403 权限不足 比如去改删别人专辑，信息
500 服务器内部错误
所有错误返回error
{"error":"解释一下错误原因"}

##login 登录

参数：
number
password

返回：
+ id
+ number
+ password
+ name
+ avatar
+ gender
+ intro
+ token

##注册

参数：
 - number
 - password
 - code
 - name
 - avatar

返回
 - info


##popularPicture 取热门推荐
将所有图片降序按照规则（collection_count*5+watch_count），返回前10张
参数：无

返回
 - picture[]


##recommendPicture 取推荐图片
算法未定
参数
 - page

返回
 - picture[]

##pictureDetail 查看图片
查看时将将图片的所有tag取出，看用户是否已有此tag，有则+1，没有则创建，分数为1.
返回相关作品，算法未定

参数
 - id

返回
 - picture[]

##grade 评分
参数
 - id
 - score

返回
 - info

##userDetail 查看用户信息
参数
 - id

返回
+ id
+ number
+ name
+ avatar
+ gender
+ intro
+ pictures[]
+ albums[]
+ collection_pictures[]
+ collection_albums[]
+ fans[]//他的粉丝，follow他的人
+ star[]//他的明星，他follow的人

##follow 关注
关注用户

参数
 - id   //被关注者id

返回
 - info

##updateUserDetail 更新用户资料
参数
+ avatar
+ name
+ gender
+ background
+ intro
返回
info

##createAlbum 创建专辑
参数
 - id //可空，如果没有这个属性，表示新建，如果有表示更新此id的信息
 - name
 - avatar
 - intro

返回
 - info

##uploadPicture 上传图片
参数
 - src
 - name
 - intro
 - height
 - width
 - album_id  //专辑id
 - tag  //eg：人物,游泳,宠物 直接保存即可

返回
 - info

##deletePicture
参数
 - id

返回
 - info

##deleteAlbum 
参数
 - id

返回
 - info