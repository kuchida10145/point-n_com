/**
 * 店舗管理のカテゴリーとエリアのライブラリ
 */

/**
 * 上位項目選択時
 * - 業種
 * - 第1エリア(都道府県)
 * - ジャンルマスター(大カテゴリー)
 */
$(function() {

	$.fn.changeUpperItem = function(option)
	{
		var url = option.url;
		var name = option.name;
		var category_large_id = $('#category_large_id').val();
		var type_of_industry_id = $('#type_of_industry_id').val();
		var prefectures_id = $('#area_first_id').val();

		var data = { category_large_id : category_large_id, type_of_industry_id : type_of_industry_id, prefectures_id : prefectures_id };

		$.ajax({
			type: "post",
			url: url,
			data: data,

			success: function(responseText, statusText) {
				//alert(responseText);
				// 結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var res = $.parseJSON(responseText);

				if (res.result == 'false') {
					alert('リスト取得に失敗しました');
					return false;
				}

				settingSelection(res.category_midium, 'category_midium_id', '上項目を選択してください');
				settingSelection(res.category_small, 'category_small_id', '上項目を選択してください');
				settingSelection(res.area_second, 'area_second_id', '上項目を選択してください');
				settingSelection(res.area_third, 'area_third_id', '上項目を選択してください');
			},
			error:function(test)
			{
				//checkObject(test);
				alert("リスト取得の呼び出しに失敗しました");
			}
		});
	}

});

/**
 * 検索条件上位項目選択時
 * - 業種
 * - 第1エリア(都道府県)
 * - ジャンルマスター(大カテゴリー)
 */
$(function() {

	$.fn.changeSearchUpperItem = function(option)
	{
		var url = option.url;
		var name = option.name;
		var category_large_id = $('#category_large_id').val();
		var prefectures_id = $('#prefectures_id').val();
		var data = { category_large_id : category_large_id, prefectures_id : prefectures_id };

		$.ajax({
			type: "post",
			url: url,
			data: data,

			success: function(responseText, statusText) {
				//alert(responseText);
				// 結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var res = $.parseJSON(responseText);

				if (res.result == 'false') {
					alert('リスト取得に失敗しました');
					return false;
				}

				settingSelection(res.category_midium, 'category_midium_id', '');
			},
			error:function(test)
			{
				//checkObject(test);
				alert("リスト取得の呼び出しに失敗しました");
			}
		});
	}

});

/**
 * 中カテゴリー選択時
 */
$(function() {

	$.fn.changeCategoryMidium = function(option)
	{
		var url = option.url;
		var name = option.name;
		var selected = option.selected;
		var data = { selected : selected };

		$.ajax({
			type: "post",
			url: url,
			data: data,

			success: function(responseText, statusText) {
				//alert(responseText);
				// 結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var res = $.parseJSON(responseText);

				if (res.result == 'false') {
					alert('リスト取得に失敗しました');
					return false;
				}

				settingSelection(res.category_small, 'category_small_id', '上項目を選択してください');
			},
			error:function(test)
			{
				//checkObject(test);
				alert("リスト取得の呼び出しに失敗しました");
			}
		});
	}

});

/**
 * 第２エリア選択時
 */
$(function() {

	$.fn.changeAreaSecond = function(option)
	{
		var url = option.url;
		var name = option.name;
		var selected = option.selected;
		var data = { selected : selected };

		$.ajax({
			type: "post",
			url: url,
			data: data,

			success: function(responseText, statusText) {
				//alert(responseText);
				// 結果がテキスト形式で来るので、jsonのオブジェクトに変換
				var res = $.parseJSON(responseText);

				if (res.result == 'false') {
					alert('リスト取得に失敗しました');
					return false;
				}

				settingSelection(res.area_third, 'area_third_id', '上項目を選択してください');
			},
			error:function(test)
			{
				//checkObject(test);
				alert("リスト取得の呼び出しに失敗しました");
			}
		});
	}

});

function settingSelection(instance, tag_id, nothing_message) {
	$('#' + tag_id + ' > option').remove();
	if (instance != null && Object.keys(instance).length > 0) {
		if (Object.keys(instance).length == 1) {
			for (var key in instance) {
				if (key == 0) {
					$('#' + tag_id).append("<option value=\"" + key + "\">" + instance[key] + "</option>");
					return;
				}
			}
		}
		$('#' + tag_id).append("<option value=\"\">選択してください</option>");
		for (var key in instance) {
			//alert(key + ": " + instance[key]);
			$('#' + tag_id).append("<option value=\"" + key + "\">" + instance[key] + "</option>");
		}
	} else {
		$('#' + tag_id).append("<option value=\"\">" + nothing_message + "</option>");
	}
}
