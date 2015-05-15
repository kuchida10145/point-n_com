var GoogleMapClient;

GoogleMapClient = function(){
	var accessor = {
		map : null,
		center : { map : null, marker : null},
		marker : null,
		popup : null,
		zoom : 15,
		setupMapCenter : function(latitude,longitude){
			var self = this;
			self.center.map = new google.maps.LatLng(latitude, longitude);
		},
		setZoom : function (zoom) {
			var self = this;
			self.zoom = zoom;
		},
		addMarker : function (latitude,longitude,icon) {
			var self = this;
			self.marker = new google.maps.Marker({
					map: self.map,
					icon : icon,
					position: new google.maps.LatLng(latitude, longitude),
					draggable: false
				});

			return self.marker;
		},
		drawMap : function(id){
			var self = this;
			var options = {
				zoom: self.zoom,
				center: self.center.map,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scaleControl: true
			};

			self.map = new google.maps.Map(document.getElementById(id), options);


		},
		attachEventMapClick : function (fn){
			var self = this;
			var map = self.map;
			var marker = self.marker;

			// クリックした位置にマーカー移動
			google.maps.event.addListener(map, 'click', function (obj) {
				var latLng = obj.latLng;

				marker.position = latLng;
				marker.setMap(map);
				fn(latLng);
				marker.setOptions({
					map: map,
					//icon: image2,
					draggable: true
				});
			});
		},
		attachMarkerPopupEvent : function(marker,html){
			var self = this;
			var map = self.map;
			var popup = new google.maps.InfoWindow({
				content: html,
				maxWidth : 500
			});
			

			google.maps.event.addListener(marker, 'click', function (obj) {

				if( self.popup ) {
					self.popup.close();
				}
				
				popup.open(self.map, marker);
				self.popup = popup;
			});
		},
		attachEventMarkerDragEnd : function(fn){
			var self = this;
			var map = self.map;
			var marker = self.marker;

			google.maps.event.addListener(marker, 'dragend', function (obj) {

				var latLng = obj.latLng;

				marker.position = latLng;
				marker.setMap(map);
				fn(latLng);
			});
		},
		attachEventMapIdle : function(fn){
			var self = this;
			var map = self.map;
			var marker = self.marker;
			// 地図の移動完了時
			google.maps.event.addListener(map, "idle", function () {

				var bounds = map.getBounds();
				var mPoint = marker.getPosition();
				var c = map.getCenter();
				var z = map.getZoom();
				if (!c) {
					return;
				}
				fn(map);
			});
		},
		showAddress : function (obj){
			var place = obj.place;
			var successfn = obj.success;
			var errorfn = obj.error;

			// ジオコーダのコンストラクタ
			var geocoder = new google.maps.Geocoder();
			// geocodeリクエストを実行。
			// 第１引数はGeocoderRequest。住所⇒緯度経度座標の変換時はaddressプロパティを入れればOK。
			// 第２引数はコールバック関数。
			geocoder.geocode({
				address: place
			}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {

					// 結果の表示範囲。結果が１つとは限らないので、LatLngBoundsで用意。
					var bounds = new google.maps.LatLngBounds();
					for (var i in results) {
						if (results[i].geometry) {

							// 緯度経度を取得
							var latlng = results[i].geometry.location;
							// 住所を取得(日本の場合だけ「日本, 」を削除)
							var address = results[0].formatted_address.replace(/^日本, /, '');

							// 検索結果地が含まれるように範囲を拡大
							bounds.extend(latlng);
							successfn(latlng);
						}
					}
				}
				else if (status == google.maps.GeocoderStatus.ZERO_RESULTS)
				{
					errorfn();
				}
			});
		},
		ajaxSearchByAddress : function(obj){
			(function($){
				$.ajax({
					"type" : "GET",
					"url" : "https://maps.googleapis.com/maps/api/geocode/json",
					"data" : {
						"address" : obj.address,
						"language" : "ja",
						"sensor" : "false"
					}
				})
				.done(obj.success)
				.fail(obj.error);
			})(jQuery)
		}

	};

	return accessor;
};
