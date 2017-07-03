<?php
namespace Curder\LaravelAliyunSms;
use Curder\AliyunCore\Profile\DefaultProfile;
use Curder\AliyunCore\DefaultAcsClient;
use Curder\AliyunCore\Regions\Endpoint;
use Curder\AliyunCore\Regions\EndpointConfig;
use Curder\AliyunCore\Regions\EndpointProvider;
use Curder\AliyunSms\Request\V20170525\SendSmsRequest;
use Curder\AliyunCore\Exception\ClientException;
use Curder\AliyunCore\Exception\ServerException;
class AliyunSms {
    /**
     * 发送短信
     * @param  string $mobile 接受短信的号码
     * @param  string $tplId  模板签名id，请在阿里云后台获取
     * @param  array $params 发送的参数
     * @return mixed         返回错误或者数组信息
     */
    public function send($mobile, $tplId, $params = array())
    {
        // 引用配置文件
        include_once dirname(dirname(dirname(__FILE__))) . '/aliyun-core/src/Config.php';
        //此处需要替换成自己的AK信息
        $accessKeyId = config('aliyunsms.access_key');//参考本文档步骤2
        $accessKeySecret = config('aliyunsms.access_secret');//参考本文档步骤2
        //暂时不支持多Region
        $region = config('aliyunsms.region_id',"cn-hangzhou");
         //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //初始化访问的acsCleint
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient= new DefaultAcsClient($profile);
        $request = new SendSmsRequest;
        //必填-短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为20个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumbers($mobile);
        //必填-短信签名
        $request->setSignName(config('aliyunsms.sign_name')); /*签名名称*/
        //必填-短信模板Code
        $request->setTemplateCode($tplId);/*模板code*/
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam(json_encode($params)); // "{\"code\":\"12345\",\"minutes\":\"5\"}"
        //选填-发送短信流水号
        $request->setOutId("1234");
        try {
            $acsResponse = $acsClient->getAcsResponse($request);
            return $acsResponse;
        } catch (ClientException  $e) {
            logger()->error('客户端错误');
            logger()->error($e->getErrorCode());
            logger()->error($e->getErrorMessage());
            throw $e;
        } catch (ServerException  $e) {
            logger()->error('服务端错误');
            logger()->error($e->getErrorCode());
            logger()->error($e->getErrorMessage());
             throw $e;
        }
        return false;
    }
}