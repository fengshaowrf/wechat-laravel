<?php
/**
 * Created by PhpStorm.
 * User: bling
 * Date: 2016/12/22
 * Time: 下午4:45
 */

namespace App\Http\Middleware;


use App\Helper\Encrypt;
use App\Http\Controllers\BaseController;
use Closure;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Support\Collection;
use Illuminate\Http\Request;

/**
 * 重写overture 微信oauth2.0 授权
 * 目的 : 1.需要获取unionid 2.微信后台绑定的授权域名已被历史项目使用 3.可以使用debug=OPENID 直接获取用户信息方便调试 4.BaseController中保存授权用户信息
 * Class UnionWechatOauth
 * @package App\Http\Middleware
 */
class UnionWechatOauth
{
    const UNION_AUTH_HOST = '';
    /**
     * Use Service Container would be much artisan.
     * @var Application $wechat
     */
    private $wechat;

    /**
     * Inject the wechat service.
     * @param Application $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth_key = $request->get('key');

        //让用户访问带加密的openid 免授权进入系统
        if ($auth_key && $openid = Encrypt::authcode($auth_key, Encrypt::DECODE)) {
            session()->flush();
            try {
                $userinfo = $this->wechat->user->get($openid);
                session(['wechat.oauth_user' => $userinfo]);
                BaseController::$user_wx = session('wechat.oauth_user');
                return $next($request);
            } catch (\Exception $exception) {

            }
        }

        //debug 环境可以直接使用debug=OPENID 访问
        if (($openid = $request->get('debug')) && config('app.debug')) {
            //存在 debug 的 openid
            session()->flush();
            $userinfo = $this->wechat->user->get($openid);
            session(['wechat.oauth_user' => $userinfo]);
            BaseController::$user_wx = session('wechat.oauth_user');
            return $next($request);
        }

        //使用mock
        if ($this->wechat->config['enable_mock']) {
            session(['wechat.oauth_user' => new Collection($this->wechat->config['mock_user'])]);
        }

        //网页授权
        if (!session('wechat.oauth_user')) {
            if ($request->has('code')) {
                $user_wx = $this->userinfo();
                if ($user_wx && isset($user_wx['openid'])) {
                    BaseController::$user_wx = $user_wx;
                    return redirect()->to($this->getTargetUrl($request));
                }
            }
            $scopes = config('wechat.oauth.scopes', ['snsapi_base']);

            if (is_string($scopes)) {
                $scopes = array_map('trim', explode(',', $scopes));
            }
            if (config('wechat.not_union_oauth') == true) {
                //正常授权
                return $this->wechat->oauth->scopes($scopes)->redirect($request->fullUrl());
            }
            //线上统一授权
            return redirect()->to($this->getUnionAuthUrl($request->fullUrl()));
        } else {
            BaseController::$user_wx = session('wechat.oauth_user');
        }
        return $next($request);
    }

    /**
     * openid 换取带unionid的用户基本信息
     * @return mixed
     */
    protected function userinfo()
    {
        try {
            $oauth_user = $this->wechat->oauth->user();
        } catch (\Exception $exception) {
            return null;
        }
        $openid = $oauth_user->id;
        $userinfo = $this->wechat->user->get($openid);
        session(['wechat.oauth_user' => $userinfo]);
        return $userinfo;
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    public function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }

    /**
     * 拼接统一授权地址
     * @param $url
     * @return string
     */
    protected function getUnionAuthUrl($url)
    {
        return self::UNION_AUTH_HOST . '?refer=' . $url;
    }
}