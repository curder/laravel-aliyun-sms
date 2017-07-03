## laravel-aliyun-sms

阿里云短信服务-Laravel，阿里云短信服务地址接入流程：https://help.aliyun.com/document_detail/55288.html?spm=5176.sms-account.109.10.56907c16jbje4H

## Install

```
composer require --prefer-dist curder/laravel-aliyun-sms "dev-master"
```

## Config

```
ALIYUN_SMS_ENABLE_HTTP_PROXY=false
ALIYUN_SMS_HTTP_PROXY_IP=127.0.0.1
ALIYUN_SMS_HTTP_PROXY_PORT=8888
ALIYUN_SMS_REGION_ID=cn-hangzhou
ALIYUN_SMS_AK=“”
ALIYUN_SMS_AS=“”
ALIYUN_SMS_SIGN_NAME=“”
```

## How to use ?
```
$smsService = App::make(AliyunSms::class);
$smsService->send(strval($mobile), 'SMS_xxx', ['code' => strval(1234), 'product' => 'xxx']);
```
> 参数分别是
