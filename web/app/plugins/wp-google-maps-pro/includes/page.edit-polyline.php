<?php
/*
Polylines functionality for WP Google Maps Pro


*/




function wpgmza_pro_add_polyline($mid) {
    global $wpgmza_tblname_maps;
    global $wpdb;
    if ($_GET['action'] == "add_polyline" && isset($mid)) {
        $res = wpgmza_get_map_data($mid);
        echo "
            

            
          
           <div class='wrap'>
                <h1>WP Google Maps</h1>
                <div class='wide'>

                    <h2>".__("Add a Polyline","wp-google-maps")."</h2>
                    <form action='?page=wp-google-maps-menu&action=edit&map_id=".$mid."' method='post' id='wpgmaps_add_polyline_form'>
                    <input type='hidden' name='wpgmaps_map_id' id='wpgmaps_map_id' value='".$mid."' />
                    <p>Line Color:<input id=\"poly_line\" name=\"poly_line\" type=\"text\" class=\"color\" value=\"000000\" /></p>   
                    <p>Opacity:<input id=\"poly_opacity\" name=\"poly_opacity\" type=\"text\" value=\"0.8\" /> (0 - 1.0) example: 0.8 for 80%</p>   
                    <p>Line Thickness:<input id=\"poly_thickness\" name=\"poly_thickness\" type=\"text\" value=\"4\" /> (0 - 50) example: 4</p>   
                    <div id=\"wpgmza_map\">&nbsp;</div>
                    <p>
                            <ul style=\"list-style:initial;\">
                                <li style=\"margin-left:30px;\">Click on the map to insert a vertex.</li>
                                <li style=\"margin-left:30px;\">Click on a vertex to remove it.</li>
                                <li style=\"margin-left:30px;\">Drag a vertex to move it.</li>
                            </ul>
                    </p>


                     <p>Polyline data:<br /><textarea name=\"wpgmza_polyline\" id=\"poly_line_list\" style=\"width:90%; height:100px; border:1px solid #ccc; background-color:#FFF; padding:5px; overflow:auto;\"></textarea>
                    <p class='submit'><input type='submit' name='wpgmza_save_polyline' class='button-primary' value='".__("Save Polyline","wp-google-maps")." &raquo;' /></p>

                    </form>
                </div>


            </div>



        ";

    }



}
function wpgmza_pro_edit_polyline($mid) {
    global $wpgmza_tblname_maps;
    global $wpdb;
    if ($_GET['action'] == "edit_polyline" && isset($mid)) {
        $res = wpgmza_get_map_data($mid);
        $pol = wpgmza_return_polyline_options($_GET['poly_id']);

        echo "
            

           <div class='wrap'>
                <h1>WP Google Maps</h1>
                <div class='wide'>

                    <h2>".__("Edit Polyline","wp-google-maps")."</h2>
                    <form action='?page=wp-google-maps-menu&action=edit&map_id=".$mid."' method='post' id='wpgmaps_edit_poly_form'>
                    <input type='hidden' name='wpgmaps_map_id' id='wpgmaps_map_id' value='".$mid."' />
                    <input type='hidden' name='wpgmaps_poly_id' id='wpgmaps_poly_id' value='".$_GET['poly_id']."' />
                    <p>Line Color:<input id=\"poly_line\" name=\"poly_line\" type=\"text\" class=\"color\" value=\"".$pol->linecolor."\" /></p>   
                    <p>Opacity:<input id=\"poly_opacity\" name=\"poly_opacity\" type=\"text\" value=\"".$pol->opacity."\" /> (0 - 1.0) example: 0.8 for 80%</p>   
                    <p>Line Thickness:<input id=\"poly_thickness\" name=\"poly_thickness\" type=\"text\" value=\"4\" /> (0 - 50) example: 4</p>   
                    <div id=\"wpgmza_map\">&nbsp;</div>
                    <p>
                            <ul style=\"list-style:initial;\">
                                <li style=\"margin-left:30px;\">Click on the map to insert a vertex.</li>
                                <li style=\"margin-left:30px;\">Click on a vertex to remove it.</li>
                                <li style=\"margin-left:30px;\">Drag a vertex to move it.</li>
                            </ul>
                    </p>

                     <p>Polygon data:<br /><textarea name=\"wpgmza_polyline\" id=\"poly_line_list\" style=\"width:90%; height:100px; border:1px solid #ccc; background-color:#FFF; padding:5px; overflow:auto;\"></textarea>
                    <p class='submit'><input type='submit' name='wpgmza_edit_polyline' class='button-primary' value='".__("Save Polyline","wp-google-maps")." &raquo;' /></p>

                    </form>
                </div>


            </div>



        ";

    }



}
function wpgmaps_admin_add_polyline_javascript($mapid) {
        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");


        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_map_type = $res->type;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }
        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) {
            $start_zoom = 5;
        }

        
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        ?>
        <link rel='stylesheet' id='wpgooglemaps-css'  href='<?php echo wpgmaps_get_plugin_url(); ?>/css/wpgmza_style.css' type='text/css' media='all' />
        <script type="text/javascript" >
            jQuery(document).ready(function(){
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
                    }
                    jQuery("#wpgmza_map").css({
                        height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                        width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'
                    });
                    wpgmza_InitMap();
                    jQuery("#poly_line").focusout(function() {
                        poly.setOptions({ strokeColor: "#"+jQuery("#poly_line").val() }); 
                    });
                    jQuery("#poly_opacity").keyup(function() {
                        poly.setOptions({ strokeOpacity: jQuery("#poly_opacity").val() }); 
                    });
                    jQuery("#poly_thickness").keyup(function() {
                        poly.setOptions({ strokeWeight: jQuery("#poly_thickness").val() }); 
                    });
                    
                    
            });
             // polygons variables
            var poly;
            var poly_markers = [];
            var poly_path = new google.maps.MVCArray;
            

            var MYMAP = {
                map: null,
                bounds: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
                  var myOptions = {
                    zoom:zoom,
                    center: latLng,
                    zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
                  }
                this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
                this.bounds = new google.maps.LatLngBounds();
                // polygons
                poly = new google.maps.Polyline({
                  strokeWeight: 3,
                  fillColor: '#66FF00'
                });
                poly.setMap(this.map);
                
                google.maps.event.addListener(this.map, 'click', addPoint);

            }
            function addPoint(event) {
                
                    
                    var path = poly.getPath();
                    path.push(event.latLng);

                    var poly_marker = new google.maps.Marker({
                      position: event.latLng,
                      map: MYMAP.map,
                      icon: "<?php echo wpgmaps_get_plugin_url()."/images/marker.png"; ?>",
                      draggable: true
                    });
                    

                    
                    poly_markers.push(poly_marker);
                    poly_marker.setTitle("#" + path.length);

                    google.maps.event.addListener(poly_marker, 'click', function() {
                      poly_marker.setMap(null);
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_markers.splice(i, 1);
                      path.removeAt(i);
                      updatePolyPath(path);    
                      }
                    );

                    google.maps.event.addListener(poly_marker, 'dragend', function() {
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      path.setAt(i, poly_marker.getPosition());
                      updatePolyPath(path);    
                      }
                    );
                        
                        
                    updatePolyPath(path);    
              }
              
              function updatePolyPath(poly_path) {
                var temp_array;
                temp_array = "";
                poly_path.forEach(function(latLng, index) { 
//                  temp_array = temp_array + " ["+ index +"] => "+ latLng + ", ";
                  temp_array = temp_array + latLng + ",";
                }); 
                jQuery("#poly_line_list").html(temp_array);
              }            


        </script>
        <?php
}
function wpgmaps_admin_edit_polyline_javascript($mapid,$polyid) {
        $res = wpgmza_get_map_data($mapid);
        
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");


        $wpgmza_lat = $res->map_start_lat;
        
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_map_type = $res->type;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }
        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) {
            $start_zoom = 5;
        }

        
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        
        
        
        $poly_array = wpgmza_return_polyline_array($polyid);

        $polyoptions = wpgmza_return_polyline_options($polyid);
        $linecolor = $polyoptions->linecolor;
        $linethickness = $polyoptions->linethickness;
        $fillopacity = $polyoptions->opacity;
        if (!$linecolor) { $linecolor = "000000"; }
        if (!$linethickness) { $fillcolor = "4"; }
        if (!$fillopacity) { $fillopacity = "0.5"; }
        $linecolor = "#".$linecolor;
                        
        

        ?>
        <link rel='stylesheet' id='wpgooglemaps-css'  href='<?php echo wpgmaps_get_plugin_url(); ?>/css/wpgmza_style.css' type='text/css' media='all' />
        <script type="text/javascript" >
             // polygons variables
            var poly;
            var poly_markers = [];
            var poly_path = new google.maps.MVCArray;
            var path;
                
            jQuery(document).ready(function(){
                
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
                    }
                    jQuery("#wpgmza_map").css({
                        height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                        width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'
                    });
                    wpgmza_InitMap();
                    
                    
                    jQuery("#poly_line").focusout(function() {
                        poly.setOptions({ strokeColor: "#"+jQuery("#poly_line").val() }); 
                    });
                    jQuery("#poly_opacity").keyup(function() {
                        poly.setOptions({ strokeOpacity: jQuery("#poly_opacity").val() }); 
                    });
                    jQuery("#poly_thickness").keyup(function() {
                        poly.setOptions({ strokeWeight: jQuery("#poly_thickness").val() }); 
                    });
            });
            

            var MYMAP = {
                map: null,
                bounds: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
                  var myOptions = {
                    zoom:zoom,
                    center: latLng,
                    zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
                  }
                this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
                this.bounds = new google.maps.LatLngBounds();
                // polygons
                
                
                
                poly = new google.maps.Polyline({
                    strokeWeight: "<?php echo $linethickness; ?>",
                    strokeColor: "<?php echo $linecolor; ?>",
                    strokeOpacity: "<?php echo $fillopacity; ?>",
                    fillColor: "<?php echo $fillcolor; ?>"
                });
                path = poly.getPath()
                addPolyline();
                

            }
            function addPolyline() {
                
                
                
                <?php
              $poly_array = wpgmza_return_polyline_array($polyid);
                    
                $polyoptions = wpgmza_return_polyline_options($polyid);
                $linecolor = $polyoptions->linecolor;
                $fillcolor = $polyoptions->fillcolor;
                $fillopacity = $polyoptions->opacity;
                if (!$linecolor) { $linecolor = "000000"; }
                if (!$fillcolor) { $fillcolor = "66FF00"; }
                if (!$fillopacity) { $fillopacity = "0.5"; }
                $linecolor = "#".$linecolor;
                $fillcolor = "#".$fillcolor;
                
                foreach ($poly_array as $single_poly) {
                    $poly_data_raw = str_replace(" ","",$single_poly);
                    $poly_data_raw = explode(",",$poly_data_raw);
                    $lat = $poly_data_raw[0];
                    $lng = $poly_data_raw[1];
                    ?>
                    var temp_gps = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>);
                    addExistingPoint(temp_gps);
                    updatePolyPath(path);
                    
                    
                    
                    <?php
                }
                ?>                
                
                poly.setMap(MYMAP.map);
                
                google.maps.event.addListener(MYMAP.map, 'click', addPoint);
            }
            function addExistingPoint(temp_gps) {
                
                
                
                path.push(temp_gps);

                var poly_marker = new google.maps.Marker({
                  position: temp_gps,
                  map: MYMAP.map,
                  draggable: true
                });
                poly_markers.push(poly_marker);
                poly_marker.setTitle("#" + path.length);
                google.maps.event.addListener(poly_marker, 'click', function() {
                      poly_marker.setMap(null);
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_markers.splice(i, 1);
                      path.removeAt(i);
                      updatePolyPath(path);    
                      }
                    );

                    google.maps.event.addListener(poly_marker, 'dragend', function() {
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      path.setAt(i, poly_marker.getPosition());
                      updatePolyPath(path);    
                      }
                    );
            }
            function addPoint(event) {
                
                   var path = poly.getPath();
                    path.push(event.latLng);

                    var poly_marker = new google.maps.Marker({
                      position: event.latLng,
                      map: MYMAP.map,
                      draggable: true
                    });


                    
                    poly_markers.push(poly_marker);
                    poly_marker.setTitle("#" + path.length);

                    google.maps.event.addListener(poly_marker, 'click', function() {
                      poly_marker.setMap(null);
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_markers.splice(i, 1);
                      path.removeAt(i);
                      updatePolyPath(path);    
                      }
                    );

                    google.maps.event.addListener(poly_marker, 'dragend', function() {
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      path.setAt(i, poly_marker.getPosition());
                      updatePolyPath(path);    
                      }
                    );
                        
                        
                    updatePolyPath(path);    
              }
              
              function updatePolyPath(poly_path) {
                var temp_array;
                temp_array = "";
                path.forEach(function(latLng, index) { 
//                  temp_array = temp_array + " ["+ index +"] => "+ latLng + ", ";
                  temp_array = temp_array + latLng + ",";
                }); 
                jQuery("#poly_line_list").html(temp_array);
              }            
             

        </script>
        <?php
}

function wpgmza_return_polyline_list($map_id,$admin = true,$width = "100%") {
    wpgmaps_debugger("return_marker_start");

    global $wpdb;
    global $wpgmza_tblname_polylines;

	$map_id = (int)$map_id;

    $results = $wpdb->get_results("
	SELECT *
	FROM $wpgmza_tblname_polylines
	WHERE `map_id` = '$map_id' ORDER BY `id` DESC
    ");
    
    $wpgmza_tmp .= "
        
        <table id=\"wpgmza_table_polyline\" class=\"display\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:$width;\">
        <thead>
        <tr>
            <th><strong>".__("ID","wp-google-maps")."</strong></th>
            <th><strong>".__("Polyline Data","wp-google-maps")."</strong></th>
            <th style='width:182px;'><strong>".__("Action","wp-google-maps")."</strong></th>
        </tr>
        </thead>
        <tbody>
    ";
    $res = wpgmza_get_map_data($map_id);
    $default_marker = "<img src='".$res->default_marker."' />";
    
    //$wpgmza_data = get_option('WPGMZA');
    //if ($wpgmza_data['map_default_marker']) { $default_icon = "<img src='".$wpgmza_data['map_default_marker']."' />"; } else { $default_icon = "<img src='".wpgmaps_get_plugin_url()."/images/marker.png' />"; }

    foreach ( $results as $result ) {
        unset($poly_data);
        unset($poly_array);
        $poly_array = wpgmza_return_polyline_array($result->id);
        foreach ($poly_array as $poly_single) {
            $poly_data .= $poly_single.",";
        } 
        $wpgmza_tmp .= "
            <tr id=\"wpgmza_poly_tr_".$result->id."\">
                <td height=\"40\">".$result->id."</td>
                <td height=\"40\"><small>".$poly_data."</small></td>
                <td width='170' align='center'>
                    <a href=\"".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu&action=edit_polyline&map_id=".$map_id."&poly_id=".$result->id."\" title=\"".__("Edit","wp-google-maps")."\" class=\"wpgmza_edit_poly_btn\" id=\"".$result->id."\">".__("Edit","wp-google-maps")."</a> |
                    <a href=\"javascript:void(0);\" title=\"".__("Delete this polyline","wp-google-maps")."\" class=\"wpgmza_polyline_del_btn\" id=\"".$result->id."\">".__("Delete","wp-google-maps")."</a>
                </td>
            </tr>";
        
    }
    $wpgmza_tmp .= "</tbody></table>";
    

    return $wpgmza_tmp;
    
}
function wpgmza_return_polyline_options($poly_id) {
    global $wpdb;
    global $wpgmza_tblname_polylines;
	
	$poly_id = (int)$poly_id;
	
    $results = $wpdb->get_results("
	SELECT *
	FROM $wpgmza_tblname_polylines
	WHERE `id` = '$poly_id' LIMIT 1
    ");
    foreach ( $results as $result ) {
        return $result;
    }
}

function wpgmza_return_polyline_array($poly_id) {
    global $wpdb;
    global $wpgmza_tblname_polylines;
	
	$poly_id = (int)$poly_id;
	
    $results = $wpdb->get_results("
	SELECT *
	FROM $wpgmza_tblname_polylines
	WHERE `id` = '$poly_id' LIMIT 1
    ");
    foreach ( $results as $result ) {
        $current_polydata = $result->polydata;
        $new_polydata = str_replace("),(","|",$current_polydata);
        $new_polydata = str_replace("(","",$new_polydata);
        $new_polydata = str_replace("),","",$new_polydata);
        $new_polydata = explode("|",$new_polydata);
        foreach ($new_polydata as $poly) {
            
            $ret[] = $poly;
        }
        return $ret;
    }
}

function wpgmza_return_polyline_id_array($map_id) {
    global $wpdb;
    global $wpgmza_tblname_polylines;
	
	$map_id = (int)$map_id;
	
    $ret = array();
       $results = $wpdb->get_results("
	SELECT *
	FROM $wpgmza_tblname_polylines
	WHERE `map_id` = '$map_id'
    ");
    foreach ( $results as $result ) {
        $current_id = $result->id;
        $ret[] = $current_id;
        
    }
    return $ret;
}