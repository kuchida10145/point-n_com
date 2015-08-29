<?php
/**
 * DBモデル
 *
 */
class Base_DbModel
{
	protected $db;
	protected $table;
	protected $use_sequence = false;	//シークエンスを使うかどうか

	public $primary_key = '';//プライマリーキー




	/**
	 * 定義されたフィールドの配列を連想配列で取得
	 *
	 * @return array
	 */
	public function getField()
	{
		return array('*');
	}

	/**
	 * 定義されたフィールドをテキスト形式にして取得
	 *
	 * @return string
	 */
	protected function getFieldText(){
		return implode(',',$this->getField());
	}

	/**
	 * コンストラクタ
	 *
	 * @param Database $db Databaseクラス
	 * @param string $table テーブル名
	 */
	public function __construct($db,$table)
	{
		$this->db = $db;
		$this->table = $table;

		if($this->primary_key == ''){
			$this->primary_key = $this->table."_id";
		}
	}

	/**
	 * データの挿入
	 *
	 * @param Array $param Insertするデータ配列
	 * @return Int 成功時は主キーを、失敗時はfalseを返す
	 */
	public function insert($param)
	{
		//シークエンスIDを取得
		if($this->use_sequence === true)
		{
			$id = $this->createSeaquence($this->table);
			$param[$this->primary_key] = $id;
		}

		if(!isset($param['regist_date']) || $param['regist_date'] == '')
		{
			$param['regist_date'] = 'NOW()';
		}
		if(!isset($param['update_date']) || $param['update_date'] == '')
		{
			$param['update_date'] = 'NOW()';
		}

		//余計な配列を取り除く
		$data = $this->setRecord($this->getField(),$param);

		if($this->db->insert($this->table,$data) === false)
		{
			return false;
		}
		if($this->use_sequence === true)
		{
			return $id;
		}
		else
		{
			$temp = $this->db->GetData('SELECT LAST_INSERT_ID() as id');
			return $temp['id'];
		}
	}


	/**
	 * シークエンスを生成
	 *
	 * @param String $table シークエンスのテーブル
	 * @return Int シークエンス
	 */
	protected function createSeaquence($table)
	{
		$this->db->query('UPDATE '.$table.'_sequence SET sequence=LAST_INSERT_ID(sequence+1)');
		$c_s= $this->db->GetData('SELECT LAST_INSERT_ID() as id');
		return $c_s['id'];
	}

	/**
	 * リミットの作成
	 *
	 * @param Int $now 現在のページ番号
	 * @param Int $cnt 取得するデータ件数
	 * @return String  LIMIT文
	 */
	public function createLimit( $now, $cnt = null)
	{
		$limit = '';
		if(!is_numeric($now) || $now =="")
		{
			$now = 0;
		}
		$now = ($now <= 0) ? 0:$now-1;

		if(is_numeric($cnt) && $cnt > 0)
		{
			$now = $now*$cnt;
			$limit = " Limit {$now},{$cnt}";
		}
		return $limit;
	}

	/**
	 * INSERT UPDATE用データ配列の生成
	 *
	 * @param Array $keys フィールド
	 * @param Array $param データ
	 * @param String $type セットタイプ（allは$keysの内容をすべて設定）
	 * @return Array 生成結果
	 */
	protected function setRecord($keys,$param,$type = 'all')
	{
		$data = array();
		foreach($keys as $key )
		{
			if($type == 'all')
			{
				$data[$key] = getParam($param,$key);
			}
			else if(array_key_exists($key,$param))
			{
				$data[$key] = $param[$key];
			}
		}
		return $data;
	}


	/**
	 * IDに該当するデータを1件取得
	 *
	 * @param int $id ID
	 * @return Array 結果
	 */
	public function findById($id)
	{

		$id = $this->db->escape_string($id);
		$feild = implode(',',$this->getField());
		$sql = "SELECT {$feild} FROM {$this->table} WHERE {$this->primary_key} = '{$id}'";

		return $this->db->getData($sql);
	}


	/**
	 * DB用に文字列をエスケープ
	 *
	 * @param String $str エスケープする文字列
	 * @return String エスケープ後の文字列
	 */
	protected function escape_string($str)
	{
		return $this->db->escape_string($str);
	}


	/**
	 * すべてのデータを無条件で取得
	 *
	 * @return Multi 検索結果
	 */
	function getAll()
	{
		$feild = $this->getFieldText();
		$sql = "SELECT {$feild} FROM {$this->table}";
		return $this->db->getAllData($sql);
	}

	/**
	 * IDに該当するデータを更新
	 *
	 * @param Int $id ID
	 * @param Array $param 更新データ
	 * @return Multi 成功時はIDが、失敗時はfalseが戻ってくる
	 */
	public function updateById($id,$param)
	{
		$id = $this->db->escape_string($id);
		$where = " {$this->primary_key} = '{$id}'";
		if(!array_key_exists('update_date',$param)){
			$param['update_date'] = 'NOW()';
		}

		$param = $this->setRecord($this->getField(),$param,'isset');

		if($this->db->update($this->table,$param,$where) !== false)
		{
			return $id;
		}
		return false;
	}


	/**
	 * IDに該当するデータを削除
	 *
	 * @param Int $id 会員ID
	 * @return Bool 結果
	 */
	public function deleteById($id)
	{
		$id = $this->db->escape_string($id);
		$where = " {$this->primary_key} = '{$id}'";
		return $this->db->delete($this->table,$where);
	}


	/**
	 * where句を指定して削除
	 *
	 * @param String $where WHERE句
	 * @return Bool 結果
	 */
	public function delete($where)
	{
		return $this->db->delete($this->table,$where);
	}


	/**
	 * データの更新
	 *
	 * @param Array $param 更新するデータ
	 * @param String $where 更新条件
	 * @return Bool 結果
	 */
	public function update($param,$where)
	{
		return $this->db->update($this->table,$param,$where);
	}


	/**
	 * 検索条件の最大件数を取得する
	 *
	 * @param Array $param パラメータ
	 */
	public function searchMaxCnt($param)
	{
		$where = $this->createWhere($param);

		if(strpos(strtolower($where),'where') === false && $where !== '')
		{
			$where = 'WHERE '.$where;
		}

		$sql = $this->searchSql()." {$where}";



		$count = $this->db->getCount($sql);
		return $count;
	}


	/**
	 * 検索して一覧で取得
	 *
	 * @param Array $param 検索情報
	 * @param String $limit 取得件数
	 * @param String $order Order句
	 */
	public function search($param ,$limit='',$order='')
	{
		$where = $this->createWhere($param);
		if($order != '')
		{
			$order = 'ORDER BY '.$order;
		}
		if(strpos(strtolower($where),'where') === false && $where !== '')
		{
			$where = 'WHERE '.$where;
		}

		$sql = $this->searchSql()." {$where} {$order} {$limit}";
		return $this->db->getAllData($sql);
	}

	/**
	 * 検索用SQL
	 *
	 * @param Array $param 検索情報
	 * @param String $limit 取得件数
	 * @param String $order Order句
	 */
	public function searchSql()
	{
		$sql = "SELECT * FROM {$this->table} ";
		return $sql;
	}

	/**
	 * 最後に発行したSQL文を取得する
	 */
	public function getLastQuerySQL() {
		$sql = $this->db->sql;
		$sql = empty($sql) ? "" : $sql;
		return $sql;
	}

	/**
	 * WHERE文の生成
	 *
	 * @param Array $param Where文生成に必要なデータ
	 * @return String Where文
	 */
	protected function createWhere($param)
	{
		$where = '';
		if(!is_array($param))
		{
			$where = $param;
			if(strpos(strtolower($where),'where') === false && $where !== '')
			{
				$where = ' WHERE '.$where;
			}
		}

		return $where;
	}
}