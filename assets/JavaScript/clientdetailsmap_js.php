<script language="javascript" type="text/javascript">
    var customIcons = {
        main: {
            icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        },
        branch: {
            icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
        }      
    };

    


    function load() {

        var map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(12.4363662, 121.972368),
            zoom: 7,
            scrollwheel: false,
            navigationControl: false,
            mapTypeId: 'roadmap'
        });

        var infoWindow = new google.maps.InfoWindow;
        var selshow = $("#selshow").val();
        var filterclientgroup = $("#filterclientgroup").val();
        var selgroupby = $("#selgroupby").val();
        var txtdatefrom = $("#txtdatefrom").val();
        var txtdateto = $("#txtdateto").val();

      // Change this depending on the name of your PHP file
        downloadUrl("clientdetailsmap/pul_refresh?selshow="+selshow
                        +"&filterclientgroup="+filterclientgroup
                        +"&selgroupby="+selgroupby
                        +"&datefrom="+txtdatefrom+"&dateto="+txtdateto, 

            function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                for (var i = 0; i < markers.length; i++) {
                    var name = markers[i].getAttribute("name");
                    var branch = markers[i].getAttribute("branch");
                    var type = markers[i].getAttribute("type");
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng")));
                    var html = "<b>" + name + "</b> <br/>" + branch;
                    var icon = customIcons[type] || {};
                    
                    if(selgroupby == 0 && selshow == 0) {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            icon: icon.icon
                        });
                    }
                    else {
                        var marker = new MarkerWithLabel({
                           position: point,
                           map: map,
                           draggable: true,
                           raiseOnDrag: true,
                           labelContent: name + "<br />" + branch,
                           labelAnchor: new google.maps.Point(35, 50),
                           labelClass: "labels", // the CSS class for the label
                           labelInBackground: false
                        });
                    }
                    bindInfoWindow(marker, map, infoWindow, html);
                }
            });

    }

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}

    $(function(){

        $('#txtdatefrom').datepicker({dateFormat: 'yy-mm-dd'});   
        $('#txtdateto').datepicker({dateFormat: 'yy-mm-dd'});   

        $("#filterclientgroup").chosen({allow_single_deselect:true, 
            no_results_text: "Not found",
            add_item_enable: false});

        load();

        $("#btnrun").click(function(){
            load();
        });


        /*
        geocoder = new google.maps.Geocoder();
        $.getJSON("clientdetailsmap/get_all_loc",
        { from: <?php echo $_GET['from']; ?>,
          to: <?php echo $_GET['to']; ?> 
        },
        function(data) {
            var tmr = 500;
            $.each(data, function(k, dat_var){
                setTimeout(function(){
                    get_long_lat(geocoder,dat_var["name"], dat_var['id']);
                }, tmr);
                tmr+=500;
            });
            
        }); */


    });

    function get_long_lat(geo_obj, address, id_val) {
        //console.log(id_val + " " + address)
        geo_obj.geocode( { 'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var loc = results[0].geometry.location;

                $('#tbl_ret > tbody:last').after("<tr><td>"+id_val+"</td><td>"+loc.lat()+"</td><td>"+loc.lng()+"</td></tr>");
            } 

            
        });
    }

</script>