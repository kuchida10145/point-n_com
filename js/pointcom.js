//ターゲットID
var c = {
    'latitude' : '#latitude',
    'longitude' : '#longitude',
    'errorTarget' : '#gps-error',
};

//現在地取得過程中エラーメッセージ
var errorMessages = {
    'noGeolocalisation' : 'お使いのブラウザーで位置情報を取得できませんでした。',
    'permissionDenied' : 'お近くのお店を探す機能を使うには現在地の共有を許可してください。',
    'positionUnavailable' : '現在地の情報を取得できませんでした。',
    'gpsTimeout' : 'タイムアウトーエラーが発生しました。',
    'unknownError' : 'エラーが発生しました。',
};

var pointcom = {

    init : function()
    {
        pointcom.initGeolocalisation();
    },

    //現在地の取得
    initGeolocalisation : function()
    {
        if (navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(setLatLong, setErrors);
        }
        else
        {
            if ($(c.errorTarget).length === 0)
                return;

            $(c.errorTarget).val(errorMessages.noGeolocalisation);
        }

        //DOMに現在地の情報を入れる
        function setLatLong(location) {
            var latitude  = location.coords.latitude;
            var longitude = location.coords.longitude;

            if ( $(c.latitude).length === 0 || $(c.longitude).length === 0 )
                return;

            $(c.latitude).val(latitude);
            $(c.longitude).val(longitude);
        }

        //エラーを扱う
        function setErrors(error) {
            
            var errorMessage;

            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = errorMessages.permissionDenied;
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = errorMessages.positionUnavailable;
                    break;
                case error.TIMEOUT:
                    errorMessage = errorMessages.gpsTimeout;
                    break;
                case error.UNKNOWN_ERROR:
                    errorMessage = errorMessages.unknownError;
                    break;
            }
            //DOMにエラーを入れる
            $(c.errorTarget).val(errorMessage);           
        }        
    },

    //Googleマップの表示
    initMap : function() {

        if( !document.getElementById(gMap.mapContainer) )
            return false;

        //マーカーなしの地図を表示
        //現在地
        var currentLatLong = new google.maps.LatLng(gMap.currentLat, gMap.currentLong);

        //地図のオプション（デザインやズームの設定）
        var mapOptions = {
            zoom : 13,
            center : currentLatLong,
            streetViewControl : false,
            panelControl : false,
            mapTypeControl : false,
        };

        //Googleマップ生成
        var map = new google.maps.Map( document.getElementById(gMap.mapContainer), mapOptions );


        //マーカーの追加
        var marker, i;
        var maxLocations = gMap.locations.length;
        var infowindow   = new google.maps.InfoWindow(); //マーカーにクリックするときに表示するinfowindow生成

        //現在地のマーカー
        marker = new google.maps.Marker({
            position : currentLatLong,
            map : map,
        });

        google.maps.event.addListener(marker, 'click', (function(marker) {
            return function() {
            infowindow.setContent('現在地');
            infowindow.open(map, marker);
            }
        })(marker));

        //近くのお店のマーカー        
        for (i = 0; i < maxLocations; i++) {  
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gMap.locations[i]['latitude'], gMap.locations[i]['longitude']),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(gMap.locations[i]['name']);
                infowindow.open(map, marker);
                }
            })(marker, i));
        }
    },    

};