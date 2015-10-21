<?php
/**
 * 請求
 */
class Bill{
	
	
	
	
	
	public function createCSV($datas,$type='admin'){
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=data.csv');
		$stream = fopen('php://output', 'w');
		$fields = array();
		$fields[] = '年月';
		if($type == 'admin'){
			$fields[] = '店舗名';
		}
		$fields[] = '支払状況';
		$fields[] = 'ポイント';
		$fields[] = 'ポイント手数料';
		$fields[] = 'ポイント未受理';
		$fields[] = 'ポイント手数料未受理';
		$fields[] = 'イベントポイント';
		$fields[] = 'イベントポイント手数料';
		$fields[] = 'イベントポイント未受理';
		$fields[] = 'イベントポイント手数料未受理';
		$fields[] = '特別ポイント';
		$fields[] = '特別ポイント手数料';
		$fields[] = '使用されたポイント（ポイント）';
		$fields[] = '使用されたポイント（ポイント）未受理';
		$fields[] = '使用されたポイント（イベント）';
		$fields[] = '使用されたポイント（イベント）未受理';
		$fields[] = '使用されたポイント（ポイントのみ）';
		$fields[] = '使用されたポイント（ポイントのみ）未受理';
		$fields[] = 'ポイントキャンセル';
		$fields[] = 'ポイントキャンセル手数料';
		$fields[] = 'イベントポイントキャンセル';
		$fields[] = 'イベントポイントキャンセル手数料';
		$fields[] = '使用されたポイント（ポイント）キャンセル';
		$fields[] = '使用されたポイント（イベント）キャンセル';
		$fields[] = '使用されたポイント（ポイントのみ）キャンセル';
		$fields[] = '前払い';
		$fields[] = '調整費';
		$fields[] = 'メモ';
		$fields[] = '合計';
		$fields[] = '支払い・払い戻し';
		mb_convert_variables("SJIS-win", "utf-8", $fields);
		fputcsv($stream,  $fields);
		foreach ($datas as $data){
			
			$fields = array();
			$total = cal_point_total($data,$type)+cal_cancel_total($data,$type);
			if( $total == 0 ){
				$pay_text = "払い戻し・支払い無し";
			}
			else if($total > 0){
				$pay_text = "支払い";
				if($type != 'admin'){
					$pay_text = "払い戻し";
				}
			}
			else{
				$pay_text = "払い戻し";
				if($type != 'admin'){
					$pay_text = "支払い";
				}
			}
			
			$fields[] = str_replace('-','年',$data['bill_month'])."月";//年月
			if($type == 'admin'){
				$fields[] = $data['store_name'];				//店舗名
			}
			$fields[] = getParam(pay_status(),$data['pay_status']);//支払状況
			$fields[] = $data['n_point'];				//ポイント
			$fields[] = $data['n_point_commission'];		//ポイント手数料
			$fields[] = $data['n_point_n'];				//ポイント未受理
			$fields[] = $data['n_point_n_commission'];	//ポイント手数料未受理
			$fields[] = $data['e_point'];				//イベントポイント
			$fields[] = $data['e_point_commission'];		//イベントポイント手数料
			$fields[] = $data['e_point_n'];				//イベントポイント未受理
			$fields[] = $data['e_point_n_commission'];	//イベントポイント手数料未受理
			$fields[] = $data['sp_point'];				//特別ポイント
			$fields[] = $data['sp_point_commission'];	//特別ポイント手数料
			$fields[] = $data['use_n_point'];			//使用されたポイント（ポイント）
			$fields[] = $data['use_n_point_n'];			//使用されたポイント（ポイント）未受理
			$fields[] = $data['use_e_point'];			//使用されたポイント（イベント）
			$fields[] = $data['use_e_point_n'];			//使用されたポイント（イベント）未受理
			$fields[] = $data['use_point'];				//使用されたポイント（ポイントのみ）
			$fields[] = $data['use_point_n'];			//使用されたポイント（ポイントのみ）未受理
			$fields[] = $data['n_point_cancel'];			//ポイントキャンセル
			$fields[] = $data['n_point_cancel_commission'];	//ポイントキャンセル手数料
			$fields[] = $data['e_point_cancel'];			//イベントポイントキャンセル
			$fields[] = $data['e_point_cancel_commission'];	//イベントポイントキャンセル手数料
			$fields[] = $data['use_n_point_cancel'];	//使用されたポイント（ポイント）キャンセル
			$fields[] = $data['use_e_point_cancel'];	//使用されたポイント（イベント）キャンセル
			$fields[] = $data['use_point_cancel'];		//使用されたポイント（ポイントのみ）キャンセル
			$fields[] = $data['deposit_price'];			//前払い
			$fields[] = $data['adjust_price'];			//調整
			$fields[] = $data['memo'];					//メモ
			$fields[] = $total;	//合計
			$fields[] = $pay_text;
			mb_convert_variables("SJIS-win", "utf-8", $fields);
			
			fputcsv($stream,  $fields);
		}
	}
	
	
	
}
