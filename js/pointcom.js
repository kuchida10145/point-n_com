//ターゲットID
var c = {
    'latitude' : '#latitude',
    'longitude' : '#longitude',
    'errorTarget' : '#gps-error',
    'requestedStoreName' : '#near-name',
    'searchStore' : '#near-search',
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

    initStoresNearPage : function()
    {
        pointcom.initGeolocalisation();
        pointcom.infiniteScroll();
        pointcom.searchNearStoreByName();
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
    initMap : function()
    {

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
            var label = i + 1;
            label = label.toString();  
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gMap.locations[i]['latitude'], gMap.locations[i]['longitude']),
                label: label,
                map: map,
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(gMap.locations[i]['name']);
                infowindow.open(map, marker);
                }
            })(marker, i));
        }
    },  

    //検索結果自動ロード(無限スクロール)
    infiniteScroll : function()
    {
      var ajaxUrl = window.location.href;
      var page_cnt = 1; //現在のページ数
      var storePerPage = 20; //SQLクエリーと共通

      $(window).scroll(function(ev) {

        var $window = $(ev.currentTarget),
        height = $window.height(),
        scrollTop = $window.scrollTop(),
        documentHeight = $(document).height();

        //スクロールがページの最後に着いたらAjaxで次のページの店舗をクエリー
        if (documentHeight === height + scrollTop) {

            page_cnt++;
            $.ajax({
                type: "GET",
                url: ajaxUrl ,
                data: { 'page' : page_cnt },
                dataType: "json",
                success: function(stores){

                    if ( !(null === stores) ) {

                        var html = "";
                        var label = (page_cnt - 1) * storePerPage + 1;

                        $.each(stores, function(i,store){

                            var storeId = store.store_id;
                            var image   = store.image1;
                            var name        = store.store_name;
                            var categ       = store.category_small_name;
                            var region  = store.region_name;
                            var title   = store.title;
                            var address1    = store.address1;
                            var address2    = (null === store.address2) ? '' : store.address2;
                            var normalPtStatus = store.normal_point_status;
                            var normalPtValue  = store.normal_point;
                            var eventPtStatus  = store.event_point_status;
                            var eventPtValue   = store.event_point;
                            textLabel = label.toString();

                            html += '<dl class="clearfix">';
                            html += '<a href="/stores/detail.php?id=' + storeId + '"></a>';
                            html += '<dt>';
                            if ( !(null === image) ) {
                                html += '<img src="../../../files/images/' + image + '" alt="" />';
                            }
                            html += '</dt>';
                            html += '<dd>';
                            html += '<span class="shop-number" style="padding-right:5px;">' + textLabel + '.</span>'
                            html += '<strong>' + name + '</strong><br />';
                            html += categ + '/' + region;
                            if ( "1" == normalPtStatus ) {
                                html += ' <strong class="pointtag">ポイント</strong>';
                                html += '<strong class="clrred">' + normalPtValue + 'PT</strong>';
                            }
                            if ( "1" == eventPtStatus ) {
                                html += ' <strong class="eventtag">イベント</strong>';
                                html += '<strong class="clrgreen">' + eventPtValue + 'PT</strong>';
                            }                       
                            html += '<br />';
                            if ( !(null === title) ) {
                                html += title + '<br />';
                            }
                            html += '住所：' + address1 + address2 + '<br />';
                            html += '</dd>';
                            html += '</dl>';

                            label++;
                        });

                        $('.shoplist').append(html);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    page_cnt--; 
                }
            });
        }
      });
    },

    //近くの店舗を店舗名で検索
    searchNearStoreByName : function()
    {
        $(c.searchStore).on('click', linkClickHandler);
        
        function linkClickHandler() {

            //探したい店舗名取得
            var requestedStoreName = $(c.requestedStoreName).val();

            if ( '' != requestedStoreName ) {

                var linkHref       = $(this).attr('href');
                requestedStoreName = encodeURIComponent(requestedStoreName);
                var newLinkHref    = updateUrlParameter(linkHref, 'keyword', requestedStoreName);

                $(this).attr('href', newLinkHref);
            } else {
                return false; //リンクを無効にする
            }
        }

        /*
        * URLのパラメータ重複を防ぐため追加
        * パラメータの切り替え対応
        * 参考：http://stackoverflow.com/a/10997390/11236
        */
        function updateUrlParameter(url, param, paramVal) {

            var newAdditionalURL = "";
            var tempArray = url.split("?");
            var baseURL = tempArray[0];
            var additionalURL = tempArray[1];
            var temp = "";
            if (additionalURL) {
                tempArray = additionalURL.split("&");
                for (i=0; i<tempArray.length; i++){
                    if(tempArray[i].split('=')[0] != param){
                        newAdditionalURL += temp + tempArray[i];
                        temp = "&";
                    }
                }
            }

            var rows_txt = temp + "" + param + "=" + paramVal;
            return baseURL + "?" + newAdditionalURL + rows_txt;
        }
    },
};