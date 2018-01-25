<?php

namespace User\Controller;

use Lookey\Wxsdk\Jssdk as WxJssdk;
use Lookey\Wxsdk\Qrcode as WxQrcode;
use Lookey\Image\Image as LookeyImage;
use Org\Util\String as Stringer;


/**
 * 分享
 *
 * @create 2016-11-7
 * @author zlw
 */
class ShareController extends BaseController
{
	
	/**
	 * 微信公众号头像名称，需要后缀
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	protected $wxoaName = '';
	
	/**
	 * 海报原始图片名称，需要后缀
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	protected $posterOldName = '';
	
	/**
	 * 构造方法
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function _initialize()
	{
		parent::_initialize();
	}
	
	/**
	 * 首页
	 *
	 * @create 2016-11-9
	 * @author zlw
	 */
    public function index()
	{
		//项目配置
		$status = $this->projectSetting();
		if ($status) {
			exit('项目暂时关闭或者还没有开启分享！请稍后重试。');
		}
		
		//同时生成二维码和海报
		$this->save_poster();
		
		$this->set_seo_title('推广分享');
		$this->display();
    }
	
	/**
	 * 生成海报
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function poster()
	{
		//项目配置
		$status = $this->projectSetting();
		if ($status) {
			exit('项目暂时关闭或者还没有开启分享！请稍后重试。');
		}
		
		//同时生成二维码和海报
		$this->save_poster();
		
		$this->set_seo_title('分享海报');
		$this->display();
    }
	
	/**
	 * 获取海报
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
    public function get_poster()
	{
		//项目配置
		$status = $this->projectSetting();
		if ($status) {
			exit('项目暂时关闭或者还没有开启分享！请稍后重试。');
		}
		
		//同时生成二维码和海报
		$this->save_poster();
		
		ob_clean();
		echo $this->posterUriPath;
		exit;
	}
	
	/**
	 * 项目配置
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
    protected function projectSetting()
	{		
		//项目ID
		$project_id = I("project_id", 0, 'intval');
		
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目错误，请重试！');
		}
		
		//项目信息
		$project = D("Project")->getOneById($project_id);
		if (empty($project)
			|| empty($project['wx_avatar'])
			|| empty($project['poster_path'])
		) {
			return false;
		}
		
		//微信公众号头像名称
		$this->wxoaName = trim($project['wx_avatar'], '/');
		
		//海报原始头像名称
		$this->posterOldName = trim($project['poster_path'], '/');
    }
	
	/**
	 * 生成海报
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    protected function save_poster()
	{
		$RewardUsers = D("RewardUsers");
		$RewardOption = D("RewardOption");
		$Project = D("Project");
		
		//项目ID
		$project_id = I("project_id", 0, 'intval');
		
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目错误，请重试！');
		}
		
		$project = $Project->getOneById($project_id);
		if (empty($project)) {
			$this->error('项目不存在，请重试！');
		}
		
		//当前用户
		$customer_id = $this->get_customer_id();
		
		//OPENID
		$wxopenid = $this->get_wx_open_id();
		
		//当前用户信息
		$rewardUsersWhere['customer_id'] = $customer_id;
		$rewardUsersWhere['project_id'] = $project_id;
		$rewardUsers = $RewardUsers->getOne($rewardUsersWhere);
		
		if (empty($rewardUsers)) {
			//记录关注信息
			$addData['pid'] = 0;
			$addData['customer_id'] = $customer_id;
			$addData['project_id'] = $project_id;
			$addData['wxopenid'] = $wxopenid;
			$addData['add_time'] = time();
			$addData['add_ip'] = get_client_ip(0, true);
			
			$checkHasAdd = $RewardUsers->addOne($addData);
		}
		
		//微信配置信息
		$appCconfig = $this->get_weixin_config();
		
		$appID = $appCconfig['appID'];
		$appSecret = $appCconfig['appSecret'];

		//获取access_token
		$WxJssdk = new WxJssdk($appID, $appSecret);
		$WxJssdk->setPath(RUNTIME_PATH . 'Weixin/');
		$accessToken = $WxJssdk->getAccessToken();
		
		//获取临时二维码
		$WxQrcode = new WxQrcode();
		$WxQrcode->setAccessToken($accessToken);
		
		$projectCode = md5($wxopenid.$project_id);
		
		//二维码地址
		$qrcodePath = C('WX.QRCODE_PATH');
		$qrcodeOldFilePath = '.' . $qrcodePath . '/' . $rewardUsers['qrcode_path'] . '.png';
		
		//用户头像地址
		$avatarPath = C('WX.AVARTAR_PATH');
		$avatarUriPath = $avatarPath . '/' . $wxopenid . '.png';
		$avatarFilePath = '.' . $avatarUriPath;

		//原始海报地址
		$posterOldFilePath = '.' . C('WX.POST_PATH') . '/' . $this->posterOldName;		
		
		//海报地址
		$posterPath = C('WX.POSTER_PATH');
		$posterUriPath = $posterPath . '/' . $projectCode . '.png';
		$posterFilePath = '.' . $posterUriPath;
		
		//微信公众号头像地址
		$wxoaPath = C('WX.WXOA_PATH');
		$wxoaUriPath = $wxoaPath . '/' . $this->wxoaName;
		$wxoaFilePath = '.' . $wxoaUriPath;
		
		//获取奖励设置信息
		$optionWhere['project_id'] = $project_id;
		$optionWhere['status'] = 1;
		$rewardOption = $RewardOption->getOne($optionWhere);
		
		if (!empty($rewardOption)) {
			$optionQrcodeTime = $rewardOption['qrcode_time'] * 24 * 60 * 60;
		} else {
			$optionQrcodeTime = 7 * 24 * 60 * 60;
		}
		
		//没有生成海报
		if ($rewardUsers['qrcode_last_time'] < time() - $optionQrcodeTime
			|| !file_exists($posterFilePath)
		) {

			//分享随机码 - 数字
			$shareCode = Stringer::randString(10, 1);
			
			$WxQrcodeConfig = array(
				'action_name' => 'QR_SCENE',
				'expire_seconds' => $optionQrcodeTime,
				'scene_id' => $shareCode,
			);
			$qrcodeInfo = $WxQrcode->getQrcode($WxQrcodeConfig);
			$showQrcodeUrl = $WxQrcode->getShowQrcodeUrl($qrcodeInfo['ticket']);
			
			//获取随机码
			//$stringer = Stringer::randString(15);
			$stringer = md5($wxopenid.$project_id);
			
			//微信图片保存地址
			$qrcodeUriPath = $qrcodePath . '/' . $stringer . '.png';
			$qrcodeFilePath = '.'.$qrcodeUriPath;

			//保存二维码图片
			
			$qrcodePngFilePath = grab_image($showQrcodeUrl, $qrcodeFilePath);
			if ($qrcodePngFilePath === false) {
				$this->error('[10001]创建失败，请稍后重试！');
			}
			
			//更改二维码信息
			$data['code'] = $shareCode;
			$data['qrcode_path'] = $stringer;
			$data['qrcode_last_time'] = time();
			$data['qrcode_url'] = $qrcodeInfo['url'];
			
			$where['project_id'] = $project_id;
			$where['customer_id'] = $customer_id;

			$checkHasEdit = $RewardUsers->editOne($where, $data);
			
			//删除原始图片 - 随机码的删除，固定的不删除
			if (file_exists($qrcodeOldFilePath) && $wxopenid != $stringer) {
				//@unlink($qrcodeOldFilePath);
			}
	
			//获取微信用户信息
			$wxUserInfo = $WxJssdk->getUserInfo($wxopenid);
			if (isset($wx_user_info['errcode'])) {
				$this->assign('errorTip', '获取用户信息错误');	
			}

			//微信用户信息
			$this->assign('wxUserInfo', $wxUserInfo);	
			
			/**=================== 用户头像 =========================**/
			
			//提取微信用户信息
			$wxUserOpenid = $wxUserInfo['openid'];
			$wxUserNickname = $wxUserInfo['nickname'];
			$wxUserSex = $wxUserInfo['sex'];
			$wxUserHeadimgurl = $wxUserInfo['headimgurl'];
		
			if (!file_exists($avatarFilePath)) {
				//保存用户头像图片到本地
				
				$avatarPngFilePath = grab_image($wxUserHeadimgurl, $avatarFilePath);
				if ($avatarPngFilePath === false) {
					$this->error('[10002]创建失败，请稍后重试！');
				}
			}

			/**=================== 海报 =========================**/
			
			$LookeyImage = new LookeyImage();
			
			//所需二维码地址
			$posterQrcodeOldPath = '.' . $qrcodePath . '/' . $projectCode . '.png';

			//打开二维码地址
			$LookeyImage->open($posterQrcodeOldPath);
			
			//添加公众号头像水印
			$LookeyImage->water($wxoaFilePath, 5, 0.25);
			
			//重新生成二维码
			$LookeyImage->save($posterQrcodeOldPath);

			//所需用户头像地址
			$posterAvatarOldPath = '.' . $avatarPath . '/' . $wxopenid . '.png';
			
			//打开原始海报
			$LookeyImage->open($posterOldFilePath);
			
			//添加用户头像水印
			$LookeyImage->water($posterAvatarOldPath, 7, 0.20, '35, 25');
			
			//添加二维码水印
			$LookeyImage->water($posterQrcodeOldPath, 9, 0.25, '15, 25');
			
			//海报高度
			$posterHeight = $LookeyImage->height();
			
			//海报宽度
			$posterWidth = $LookeyImage->width();
			
			//字体路径
			$ttfPath = $LookeyImage->getTtfPath() . '/6.ttf';
			
			//添加昵称文字水印
			/**
			$LookeyImage->text(
				$wxUserNickname, 
				$ttfPath,
				'27',
				'#FFBC8F8F', //颜色
				array(($posterWidth * 0.13) / 2, $posterHeight * 0.84),
				5
			);
			*/
			
			//生成海报
			$LookeyImage->save($posterFilePath);
		} else {
			//已生成二维码
			$qrcodePath = C('WX.QRCODE_PATH');
			$qrcodeUriPath = $qrcodePath . '/' . $rewardUsers['qrcode_path'] . '.png';
		}
		
		//二维码地址
		$this->assign('qrcodeUriPath', $qrcodeUriPath);	
		
		//用户头像地址
		$this->assign('avatarUriPath', $avatarUriPath);	
		
		//海报地址
		$this->assign('posterUriPath', $posterUriPath);	
    }
	
}

