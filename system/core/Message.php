<?php
/**
 * メッセージクラス
 */
require_once(dirname(__FILE__).'/message/MsgModel.php');
class Base_Message
{

	protected  $models = array();

	/**
	 * メッセージのモデルクラスを取得
	 *
	 * @param String $model 取得するモデルクラス名
	 */
	public function get($model)
	{
		//モデルが生成されていない場合
		if(!array_key_exists($model,$this->models))
		{
			$model_name = ucwords($model).'MsgModel';
			$model_file = dirname(__FILE__).'/../model/message/'.$model_name.'.php';

			//モデルのファイルが存在する場合
			if(is_readable($model_file))
			{
				require_once($model_file);

				$this->models[$model] =  new $model_name();
			}
			else
			{
				exit($model.' is not readable!');
			}
		}
		return $this->models[$model];
	}
}
