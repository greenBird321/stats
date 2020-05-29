## 说明

登录统计接口(选角或者创建角色以后调用)
/stats/login

参数名 | 类型 | 必选 | 描述
--- | --- |:---:| ---
app_id  | int(11)       | 是 | 应用ID
zone    | varchar(16)   | 是 | 区服ID
user_id | int(11)       | 是 | 游戏用户ID
uuid    | varchar(36)   | 是 | 设备信息  
adid    | varchar(36)   | 否 | 广告追踪标志
device  | varchar(36)   | 否 | 设备信息
version | varchar(16)   | 否 | 版本信息
channel | varchar(16)   | 否 | 渠道
type    | int(3)        | 是 | 登录类型 1新创建角色, 0角色登录

成功返回：
```json
{"code":0,"msg":"success"}
```

失败返回：
```json
{"code":1,"msg":"missing"}
```

激活日志(第一次安装调用)
/stats/install

参数名 | 类型 | 必选 | 描述
--- | --- |:---:| ---
app_id  | int(11)       | 是 | 应用ID
uuid    | varchar(36)   | 是 | 设备信息  
adid    | varchar(36)   | 否 | 广告追踪标志
device  | varchar(36)   | 否 | 设备信息
version | varchar(16)   | 否 | 版本信息
channel | varchar(16)   | 否 | 渠道

成功返回：
```json
{"code":0,"msg":"success"}
```

失败返回：
```json
{"code":1,"msg":"missing"}
```

进服统计接口(选服时调用，还没进入角色之前)
/stats/into

参数名 | 类型 | 必选 | 描述
--- | --- |:---:| ---
app_id  | int(11)       | 是 | 应用ID
zone    | varchar(16)   | 是 | 区服ID
user_id | int(11)       | 是 | 游戏用户ID
uuid    | varchar(36)   | 是 | 设备信息  
adid    | varchar(36)   | 否 | 广告追踪标志
device  | varchar(36)   | 否 | 设备信息
version | varchar(16)   | 否 | 版本信息
channel | varchar(16)   | 否 | 渠道

成功返回：
```json
{"code":0,"msg":"success"}
```

失败返回：
```json
{"code":1,"msg":"missing"}