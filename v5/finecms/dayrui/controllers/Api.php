<?php

/**
 * FineCMS 公益软件
 *
 * @策划人 李睿
 * @开发组自愿者  邢鹏程 刘毅 陈锦辉 孙华军
 */
 
class Api extends M_Controller {


    /**
     * 会员登录信息JS调用
     */
    public function member() {
        ob_start();
        $this->template->display('member.html');
        $html = ob_get_contents();
        ob_clean();
		$format = $this->input->get('format');
		// 页面输出
		if ($format == 'jsonp') {
			$data = $this->callback_json(array('html' => $html));
			echo $this->input->get('callback', TRUE).'('.$data.')';
		} elseif ($format == 'json') {
			echo $this->callback_json(array('html' => $html));
		} else {
			echo 'document.write("'.addslashes(str_replace(array("\r", "\n", "\t", chr(13)), array('', '', '', ''), $html)).'");';
		}
        exit;
    }


    /**
     * 自定义信息JS调用
     */
    public function template() {
        $this->api_template();
    }

    /**
     * ajax 动态调用
     */
    public function html() {

        ob_start();
        $this->template->cron = 0;
        $_GET['page'] = max(1, (int)$this->input->get('page'));
        $params = dr_string2array(urldecode($this->input->get('params')));
        $params['get'] = @json_decode(urldecode($this->input->get('get')), TRUE);
        $this->template->assign($params);
        $name = str_replace(array('\\', '/', '..', '<', '>'), '', dr_safe_replace($this->input->get('name', TRUE)));
        $this->template->display(strpos($name, '.html') ? $name : $name.'.html');
        $html = ob_get_contents();
        ob_clean();

        // 页面输出
        $format = $this->input->get('format');
        if ($format == 'html') {
            exit($html);
        } elseif ($format == 'json') {
            echo $this->callback_json(array('html' => $html));
        } elseif ($format == 'js') {
            echo 'document.write("'.addslashes(str_replace(array("\r", "\n", "\t", chr(13)), array('', '', '', ''), $html)).'");';
        } else {
            $data = $this->callback_json(array('html' => $html));
            echo $this->input->get('callback', TRUE).'('.$data.')';
        }
    }

    /**
	 * 更新浏览数
	 */
	public function hits() {
	
	    $id = (int)$this->input->get('id');
	    $dir = dr_safe_replace($this->input->get('module', TRUE));
        $mod = $this->module[$dir];
        if (!$mod) {
            $data = $this->callback_json(array('html' => 0));
            echo $this->input->get('callback', TRUE).'('.$data.')';exit;
        }

        // 获取主表时间段
        $data = $this->db
                     ->where('id', $id)
                     ->select('hits,updatetime')
                     ->get($this->db->dbprefix(SITE_ID.'_'.$dir))
                     ->row_array();
        $hits = (int)$data['hits'] + 1;

        // 更新主表
		$this->db->where('id', $id)->update(SITE_ID.'_'.$dir, array('hits' => $hits));

        // 输出数据
        echo $this->input->get('callback', TRUE).'('.$this->callback_json(array('html' => $hits)).')';exit;
	}


	
	/**
	 * 伪静态测试
	 */
	public function test() {
		header('Content-Type: text/html; charset=utf-8');
		echo '服务器支持伪静态';
	}
	

	
	/**
	 * 自定义数据调用（新版本）
	 */
	public function data2() {

        $data = array();

        // 安全码认证
        $auth = $this->input->get('auth', true);
        if ($auth != md5(SYS_KEY)) {
            // 授权认证码不正确
            $data = array('msg' => '授权认证码不正确', 'code' => 0);
        } else {
            // 解析数据
            $cache = '';
            $param = $this->input->get('param');
            if (isset($param['cache']) && $param['cache']) {
                $cache = md5(dr_array2string($param));
                $data = $this->get_cache_data($cache);
            }
            if (!$data) {

                // list数据查询
                $data = $this->template->list_tag($param);
                $data['code'] = $data['error'] ? 0 : 1;
                unset($data['sql'], $data['pages']);

                // 缓存数据
                $cache && $this->set_cache_data($cache, $data, $param['cache']);
            }
        }

		// 接收参数
		$format = $this->input->get('format');
		$function = $this->input->get('function');
        if ($function) {
            if (!function_exists($function)) {
                $data = array('msg' => fc_lang('自定义函数'.$function.'不存在'), 'code' => 0);
            } else {
                $data = $function($data);
            }
        }

		// 页面输出
		if ($format == 'php') {
			print_r($data);
		} elseif ($format == 'jsonp') {
			// 自定义返回名称
			echo $this->input->get('callback', TRUE).'('.$this->callback_json($data).')';
		} else {
			// 自定义返回名称
			echo $this->callback_json($data);
		}
		exit;
	}

    /**
     * 站点间的同步登录
     */
    public function synlogin() {
        $this->api_synlogin();
    }

    /**
     * 站点间的同步退出
     */
    public function synlogout() {
        $this->api_synlogout();
    }
}
