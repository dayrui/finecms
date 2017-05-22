<?php

class Admin extends Common {
	
	protected $user;
	protected $roleid;
	protected $userinfo;
	protected $site_url;

	public function __construct() {
		parent::__construct();
        define('IS_FC_ADMIN', intval(SYS_MODE));
        if (SYS_MODE == 1) {
            // 中级
        } elseif (SYS_MODE == 2) {
            // 高级
        } else {
            // 初级
        }
		$this->user = $this->model('user');
		$this->isAdminLogin();
        !auth::check($this->roleid, $this->controller . '-' . $this->action, $this->namespace)
        && $this->adminMsg(lang('a-com-0', array('1' => $this->controller, '2' => $this->action)));
		$sites = App::get_site();
		$this->site_url = 'http://' . $sites[$this->siteid]['DOMAIN'];
        $this->view->assign(array(
			'userinfo' => $this->userinfo,
			'site_url' => $this->site_url
		));
        $this->adminLog();
	}
	
	/**
     * 系统默认菜单
     */
    protected function sysMenu() {

		$menu = $this->load_config('admin.menu');
        if ($this->site['SYS_MEMBER']) {
            unset($menu['member']); // 关闭会员菜单
        }

		$data = $this->cache->get('plugin');
		if ($data) {
			foreach ($data as $t) {
				$id = $t['pluginid'];
				$url = $t['typeid'] ? url($t['dir'] . '/admin/index/', array('siteid' => $this->siteid)) : url('admin/plugin/set', array('pluginid' => $id));
				$menu['plugin']['menu'][] = array(
					'name' => $t['name'],
					'url' => $url,
				);
			}
		}
		$model = $this->get_model('form');	//表单模型
		if ($model) {
			$f = null;
		    foreach ($model as $t) {
				if ($this->adminPost($t['setting']['auth'])) {
                    continue;
                }
				$id = $t['modelid'];
				$url = url('admin/form/list', array('modelid' => $id));
				$menu['site']['menu'][] = array(
					'name' => $t['modelname'].'管理',
					'url' => $url
				);
			}
		}
		$model = $this->cache->get('model_member_extend');	//会员扩展模型
		if ($model) {
			$f = null;
		    foreach ($model as $t) {
				if ($this->adminPost($t['setting']['auth'])) {
                    continue;
                }
				$id = $t['modelid'];
				$url = url('admin/member/extend', array('modelid' => $id));
				$menu['member']['menu'][] = array(
					'name' => $t['modelname'],
					'url' => $url
				);
			}
		}
		return $menu;
    }
	
	/**
     * 获取具有审核权限的栏目
     */
	protected function getVerifyCatid() {
		if ($this->userinfo['roleid'] == 1) {
            return false;
        }
		$catid = array();
		foreach ($this->cats as $t) {
            $t['typeid'] == 1
            && $t['child'] == 0
            && $this->verifyPost($t['setting'])
            && $catid[] = $t['catid'];
		}
		return empty($catid) ? false : $catid;
	}
	
	/**
     * 投稿审核权限判断
     */
	protected function verifyPost($data) {
		if ($this->userinfo['roleid'] == 1) {
            return false;
        }
		if (isset($data['verifypost'])
            && $data['verifypost']
            && $data['verifyrole']
            && !in_array($this->userinfo['roleid'], $data['verifyrole'])) {
			return true;
		}
		return false;
	}
	
	/**
     * 后台投稿权限判断
     */
	protected function adminPost($data) {
		if (isset($data['adminpost'])
            && $data['adminpost']
            && $data['rolepost']
            && in_array($this->userinfo['roleid'], $data['rolepost'])) {
			return true;
		} elseif (isset($data['siteuser'])
            && $data['siteuser']
            && $data['site']
            && in_array($this->siteid, $data['site'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
     * 后台登陆检查
     */
    protected function isAdminLogin($namespace = 'admin', $controller = null) {
	    if ($this->namespace != $namespace) {
            return false;
        }
        if ($controller
            && $this->controller != $controller) {
            return false;
        }
        if ($this->namespace == 'admin'
            && $this->controller == 'login') {
            return false;
        }
        if ($this->session->is_set('user_id')) {
            $userid = $this->session->get('user_id');
            $this->userinfo = $this->user->userinfo($userid);
            if ($this->userinfo) {
				$this->roleid = $this->userinfo['roleid'];
			    if (empty($this->userinfo['site'])
                    || $this->userinfo['site'] == $this->siteid) {
                    return false;
                }
            }
        }
		$url = $this->namespace == 'admin' && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != 's=' . ADMIN_NAMESPACE ? url('admin/login', array('url' => urlencode(SITE_PATH . ENTRY_SCRIPT_NAME . '?' . $_SERVER['QUERY_STRING']))) : url('admin/login');
        $this->redirect($url);
    }
    
    /**
     * 指定用户组的操作菜单
     */
    protected function optionMenu($roleid = 0) {
        $menu = $this->sysMenu();
        $roleid = $roleid ? $roleid : $this->roleid;
		//加载用户自定义菜单
		$usermenu = string2array($this->userinfo['usermenu']);
        if ($roleid == 1) {
			if (!empty($usermenu)) {
				foreach ($usermenu as $k => $t) {
					$menu['index']['menu'][] = array(
						'name' => $t['name'],
						'url' => str_replace('{site}', $this->siteid, $t['url'])
					);
				}
			}
			return $menu;
		}

		if (!empty($usermenu)) {
			foreach ($usermenu as $k => $t) {
				$menu['index']['menu'][] = array(
					'name' => $t['name'],
					'url' => str_replace('{site}', $this->siteid, $t['url'])
				);
			}
		}
		// 判断权限
	    foreach ($menu as $id => $t) {
	        if ($t['menu']) {
				foreach ($t['menu'] as $iid => $r) {
					//内菜单控制
					if ($r['uri'] && !$this->checkUserAuth(array($r['uri']), $roleid)) {
						unset($menu[$id]['menu'][$iid]);
					} else {
						$menu[$id]['menu'][$iid]['url'] = $r['url'] ? $r['url'] : url($r['uri']);
					}

				}
				//如果子菜单全部被删除
				if (empty($menu[$id]['menu'])) {
					unset($menu[$id]['menu']);
				}
			}
	    }
        return $menu;
    }
    
    /**
     * 验证角色是否对指定菜单有操作权限
     */
    protected function checkUserAuth($option, $roleid = 0) {
        $data_role = require CONFIG_DIR . 'auth.role.ini.php';
        $roleid = $roleid ? $roleid : $this->roleid;
        $role = $data_role[$roleid];
        if (!$role) {
            return false;
        }
        if (!is_array($option)) {
            $option = array($option);
        }
        foreach ($role as $t) {
            if (in_array($t, $option)) {
                return true;
            }
        }
        return false;
    }
	
	/**
     * 后台操作日志记录
     */
    protected function adminLog() {
        if ($this->namespace != 'admin') {
            return false;
        }
		if (!isset($_POST) || empty($_POST)) {
            return false;
        }
        //跳过不要记录的操作
        if ($this->site['SITE_ADMINLOG'] == false) {
            return false;
        }
        $skip = require CONFIG_DIR . 'auth.skip.ini.php';
	    if (stripos($this->action, 'ajax') !== false) {
            return false;
        }
	    $skip = $skip['admin'];
	    $skip[] = 'index-log';
	    if (in_array($this->controller, $skip)) {
	        return false;
	    } elseif (in_array($this->controller . '-' . $this->action, $skip)) {
	        return false;
	    }
	    //记录操作日志
	    $options = require CONFIG_DIR . 'auth.option.ini.php';
	    $option = $options[$this->controller];
	    if (empty($option)) {
            return false;
        }
	    //$now = $option['option'][$this->action];
	    $ip = client::get_user_ip();
        if (SYS_DOMAIN) {
            $_SERVER['REQUEST_URI'] = str_replace('/' . SYS_DOMAIN, '', $_SERVER['REQUEST_URI']);
        }
		$pathurl = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
		$options = lang($option['name']) . ' - ' . lang($option['option'][$this->action]);
		if ($this->post('submit')) {
		    $options  .= ' - ' . lang('a-com-2');
		} elseif (($this->post('submit_order'))) {
		     $options .= ' - ' . lang('a-com-3');
		} elseif (($this->post('submit_del'))) {
		     $options .= ' - ' . lang('a-com-4');
		} elseif (($this->post('submit_status_1'))) {
		     $options .= ' - ' . lang('a-com-5');
		} elseif (($this->post('submit_status_0'))) {
		     $options .= ' - ' . lang('a-com-6');
		} elseif (($this->post('submit_status_2'))) {
		     $options .= ' - ' . lang('a-com-7');
		} elseif (($this->post('submit_status_3'))) {
		     $options .= ' - ' . lang('a-com-8');
		} elseif (($this->post('submit_move'))) {
		     $options .= ' - ' . lang('a-com-9');
		} elseif (($this->post('delete'))) {
		     $options .= ' - ' . lang('a-com-10');
		}
	    $data = array(
	        'ip' => $ip,
	        'param' => $pathurl,
	        'userid' => (int)$this->userinfo['userid'],
	        'action' => $this->action,
	        'options' => $options,
	        'username' => $this->userinfo['username'],
	        'controller' => $this->controller,
	        'optiontime' => time()
	    );
		$dir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
		$file = $dir . date('Ymd') . '.log';
        !is_dir($dir) && mkdir($dir, 0777);
		$content = file_exists($file) ? file_get_contents($file) : '';
		$content = serialize($data) . PHP_EOL . $content;
		file_put_contents($file, $content, LOCK_EX);
    }
	
    /**
     * 删除目录及文件
     */
    protected function delDir($filename) {
        if (empty($filename)) {
            return false;
        }
        if (is_file($filename) && file_exists($filename)) {
            unlink($filename);
        } else if ($filename != '.' && $filename != '..' && is_dir($filename)) {
            $dirs = scandir($filename);
            foreach ($dirs as $file) {
                $file != '.' && $file != '..' && $this->delDir($filename . '/' . $file);
            }
            rmdir($filename);
        }
    }
	/**
	 * 生成栏目html
	 */
	protected function createCat($cat, $page = 1) {
	    if ($cat['typeid'] == 3) {
            return false;
        }
		if ($cat['setting']['url']['use'] == 0
            || $cat['setting']['url']['tohtml'] == 0
            || $cat['setting']['url']['list'] == '') {
            return false;
        }

	    $url = substr($this->getCaturl($cat, $page), strlen(self::get_base_url())); //去掉域名部分
        if (strpos($url, 'index.php') !== false || strpos($url, 'http://') != false) {
            return false;
        }
	    if (substr($url, -5) != '.html') { 
			$file = 'index.html'; //文件名
			$dir = $url; //目录
		} else {
			$file = basename($url);
			$dir = str_replace($file, '', $url);
		}
		$this->mkdirs($dir);
		$dir = substr($dir, -1) == '/' ? substr($dir, 0, -1) : $dir;
		$htmlfile = $dir ? $dir . '/' . $file : $file;

		ob_start();
		$catid = $cat['catid'];
        $cat = $this->cats[$catid];
        if (empty($cat)) {
            return;
        }
        $this->view->setTheme(true);
        if ($cat['typeid'] == 1) {
            //内部栏目
            $this->view->assign($cat);
            $this->view->assign(listSeo($cat, $page));
            $this->view->assign(array(
                'page' => $page,
                'catid' => $catid,
                'pageurl' => urlencode($this->getCaturl($cat, '{page}'))
            ));
            $this->view->display(substr(($cat['child'] == 1 ? $cat['categorytpl'] : $cat['listtpl']), 0, -5));
        } elseif ($cat['typeid'] == 2) {
            //单网页
            $cat = $this->get_content_page($cat, 0, $page);
            $cat['content'] = relatedlink($cat['content']);
            $this->view->assign($cat);
            $this->view->assign(listSeo($cat, $page));
            $this->view->display(substr($cat['showtpl'], 0, -5));
        }
        $this->view->setTheme(false);
        (!file_put_contents($htmlfile, ob_get_clean(), LOCK_EX))
        && $this->adminMsg(lang('a-com-11', array('1' => $htmlfile)));

		$htmlfiles = $this->cache->get('html_files');
		$htmlfiles[] = $htmlfile;
		if (empty($page) || $page == 1) {
		    $onefile = str_replace('{page}', 1, substr($this->getCaturl($cat, '{page}'), strlen(self::get_base_url())));
			@copy($htmlfile, $onefile);
			$htmlfiles[] = $onefile;
		}
		$this->cache->set('html_files', $htmlfiles);
		if (strpos($cat['content'], '{-page-}') !== false) {
			$content = explode('{-page-}', $cat['content']);
			$pageid = count($content) >= $page ? ($page - 1) : (count($content) - 1);
			$page_id = 1;
			$pagelist = array();
			$cat['content'] = $content[$pageid];
			foreach ($content as $t) {
				$pagelist[$page_id] = getCaturl($cat, $page_id);
				$page_id ++ ;
			}
            isset($pagelist[$page+1]) && $this->createCat($cat, $page + 1);
		}
		return true;
	}
	
	/**
	 * 获取更新缓存JS代码
	 */
	protected function getCacheCode($c, $a = 'cache') {
		return '<script type="text/javascript" src="' . url('admin/index/updatecache', array('cc' => $c, 'ca' => $a)) . '"></script>';
	}
    /**
     * Check repeated category in given tag/tags.
     * @param $data
     * @param int $mode
     * @return bool
     */
    public function checkRepeat($data, $mode = 0, $id= 0)
    {
        if($mode === 0) {
            foreach ($data as $id => $t)
            {
                $catid = $t['catid'];
                $name = $t['name'];
                unset($data[$id]);
                foreach ($data as $d) {
                    if(in_array($catid,$d) && in_array($name,$d))
                        return  TRUE;

                }
            }
            return FALSE;
        }
        elseif($mode === 1)
        {
            $count = $this->db->where('id <> '.$id)->where(array('catid' => $data['catid'], 'name' => $data['name']))->count_all_results('tag');

            return $count > 0 ? TRUE : FALSE;
        }
        else
        {
            $count = $this->db->where('id <> '.$id)->where(array('catid' => $data['catid'], 'name' => $data['name']))->count_all_results('tag');

            return $count > 1 ? TRUE : FALSE;
        }

    }
	
}