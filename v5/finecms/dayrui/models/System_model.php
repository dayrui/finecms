<?php
/**
 * FineCMS 公益软件
 *
 * @策划人 李睿
 * @开发组自愿者  邢鹏程 刘毅 陈锦辉 孙华军
 */
	
class System_model extends CI_Model {

	
	/*
	 * 缓存表
	 *
	 * @return	array
	 */
	public function cache() {
	
		$table = array();
		
		// 主数据库表查询
		$_table = $this->db->query("SHOW TABLE STATUS FROM `{$this->db->database}`")->result_array();
		foreach ($_table as $t) {
			if (strpos($t['Name'], $this->db->dbprefix) === 0 && strpos($t['Name'], '-') === false) {
				#$this->db->query('REPAIR TABLE '.$t['Name']);
				$_field = $this->db->query('SHOW FULL COLUMNS FROM `'.$t['Name'].'`')->result_array();
				foreach ($_field as $c) {
					$t['field'][$c['Field']] = array(
						'name' => $c['Field'],
						'type' => $c['Type'],
						'note' => $c['Comment']
					);
				}
				$table[$t['Name']]	= array(
					'name' => $t['Name'],
					'rows' => $t['Rows'],
					'note' => $t['Comment'],
					'free' => $t['Data_free'], // 多余空间
					'field' => $t['field'],
					'siteid' => 0, // 主数据库
					'update' => $t['Update_time'],
					'filesize' => $t['Data_length'] + $t['Index_length'],
					'collation'	=> $t['Collation'],
				);
			}
		}
		

		$this->dcache->set('table', $table);
		
		return $table;
	}
	
	/*
	 * 系统表
	 * 
	 * @return	array
	 */
	public function get_system_table() {
	
		$list = array();
		$data = $this->dcache->get('table');
        !$data && $data = $this->cache();
		
		foreach ($data as $t) {
            !preg_match('/'.$this->db->dbprefix.'[0-9]+_/', $t['name']) && $list[] = $t;
		}
		
		return $list;
	}
	
	/*
	 * 站点表
	 * 
	 * @param	intval	$siteid
	 * @return	array
	 */
	public function get_site_table($siteid) {
	
		$list = array();
		$data = $this->dcache->get('table');
        !$data && $data = $this->cache();
		
		foreach ($data as $t) {
            preg_match('/'.$this->db->dbprefix.$siteid.'_/', $t['name']) && $list[] = $t;
		}
		
		return $list;
	}


    // 更新URL缓存
    public function urlrule() {

        $this->ci->dcache->delete('urlrule');
        $data = $this->db->get('urlrule')->result_array();
        $cache = array();
        if ($data) {
            foreach ($data as $t) {
                $t['value'] = dr_string2array($t['value']);
                if ($t['value'] && ($t['type'] == 2 || $t['type'] == 3)) {
                    // 当为内容模型URL时,复制值给独立模型
                    foreach ($t['value'] as $var => $val) {
                        strpos($var, 'share_') === 0 && $t['value'][str_replace('share_', '', $var)] = $val;
                    }
                }
                $cache[$t['id']] = $t;
            }
            $this->ci->dcache->set('urlrule', $cache);
        }

        $this->ci->clear_cache('urlrule');
        return $cache;
    }



    // 更新邮件缓存
    public function email() {

        $this->dcache->delete('email');
        $data = $this->db->order_by('displayorder asc')->get('mail_smtp')->result_array();
        $data && $this->dcache->set('email', $data);
        $this->ci->clear_cache('email');
        return $data;
    }


    // 文字块缓存
    public function block($site) {

        $this->ci->clear_cache('block-'.$site);
        $this->ci->dcache->delete('block-'.$site);

        $data = $this->db->get($site.'_block')->result_array();
        $cache = array();
        if ($data) {
            foreach ($data as $t) {
                $t = dr_get_block_value($t);
                switch (intval($t['i'])) {
                    case 1:
                        // 文本内容
                        $value = $t['value_1'];
                        break;
                    case 2:
                        // 丰富文本
                        $value = $t['value_2'];
                        break;
                    case 3:
                        // 单文件
                        $value = $t['value_3'];
                        break;
                    case 4:
                        // 多文件
                        $value = dr_string2array($t['value_4']);
                        break;
                }

                $cache[$t['id']] = array(
                    1 => $t['name'],
                    0 => $value,
                );
            }
            $this->ci->dcache->set('block-'.$site, $cache);
        }

        return $cache;
    }

}