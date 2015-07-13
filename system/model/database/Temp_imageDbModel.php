<?php
/**
 * 一時画像
 */
class Temp_imageDbModel extends DbModel{



	
	public function getField(){
		return array(
			'temp_image_id',
			'use_state',
			'dir_path',
			'file_name',
			'regist_date',
			'update_date',
			'delete_flg'

		);
	}
	
	/**
	 * ファイル名に該当するデータを1件取得
	 *
	 * @param string $filename ファイル名
	 * @return Array 結果
	 */
	public function findByFileName($filename) {
		$filename = $this->db->escape_string($filename);
		$fields = $this->getFieldText();
		$sql = "SELECT {$fields} FROM {$this->table} WHERE `file_name` = '{$filename}'";
		return $this->db->getData($sql);
	}
	
	/**
	 * ファイル名に該当するデータを更新
	 *
	 * @param String $filename ファイル名
	 * @param Array $param 更新データ
	 * @return Multi 成功時はtrueが、失敗時はfalseが戻ってくる
	 */
	public function updateByFileName($filename, $param) {
		$filename = $this->db->escape_string($filename);
		$where = " `file_name` = '{$filename}' ";
		if (!array_key_exists('update_date', $param)) {
			$param['update_date'] = 'NOW()';
		}
		
		$param = $this->setRecord($this->getField(), $param, 'isset');
		
		if ($this->db->update($this->table, $param, $where) !== false) {
			return true;
		}
		return false;
	}
	
	/**
	 * 使用状態に該当するデータを取得する
	 * 
	 * @param int $use_state
	 * @return array
	 */
	public function getListForUseState($use_state) {
		$use_state = $this->db->escape_string($use_state);
		$fields = $this->getFieldText();
		$sql = "SELECT {$fields} FROM {$this->table} WHERE `use_state` = '{$use_state}' ";
		return $this->db->getAllData($sql);
	}
}