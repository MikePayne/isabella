<?php

/**
 * Marker Listing Class
 *
 * This class handles the output of all marker listing types.
 *
 * @admin		   [bool]  [Is the list being outputted to the admin area or not]
 * @type			[int]   [Type ID  1: Basic Table. 2: Advanced Table. 3: Carousel Listing. 4: Basic List]
 * @map_id		  [int]   []
 * @category_data   [array] []
 * @mashup		  [bool]  []
 * @mashup_ids	  [array] []
 * @mmarker_array   [array] []
 * @order_by		[int]   []
 * @order		   [int]   []
 */

namespace WPGMZA;
 
// Legacy support
class_alias('WPGMZA\\MarkerListing', 'wpgmza');

class MarkerListing {
	
	function list_markers($admin = false,$type = 1,$map_id = false,$category_data = false,$mashup = false,$mashup_ids = false,$marker_array = false,$order_by = false,$order = false,$include_mlist_div = true) {
		global $wpdb;
		global $wpgmza_tblname;
		
		$res = $this->get_map_data($map_id);

		$width = stripslashes(trim($res->map_width)).stripslashes(trim($res->map_width_type));
		
		
		// marker sorting functionality
		if ($res->order_markers_by == '1') { $order_by = "id"; }
		else if ($res->order_markers_by == '2') { $order_by = "title";  }
		else if ($res->order_markers_by == '3') { $order_by = "address"; }
		else if ($res->order_markers_by == '4') { $order_by = "description"; }
		else if ($res->order_markers_by == '5') { $order_by = "category"; }
		else { $order_by = "id"; }

		if ($res->order_markers_choice == '1') { $order_choice = "ASC"; }
		else { $order_choice = "DESC"; }

		if(!empty($_POST['mashup_ids']))
		{
			$mashup = true;
			$mashup_ids = explode(',', $_POST['mashup_ids']);
		}
		
		if ($mashup) {
			// map mashup
			$map_ids = $mashup_ids;
			$wpgmza_cnt = 0;

			if ($mashup_ids[0] == "ALL") {
				$wpgmza_sql1 = "
				SELECT *
				FROM $wpgmza_tblname
				ORDER BY `id` DESC
				";
			}
			else {
				$where = "map_id IN (" . implode(',', array_map('intval', $mashup_ids)) . ")";
				
				$wpgmza_sql1 = "
				SELECT *
				FROM $wpgmza_tblname
				WHERE $where ORDER BY `id` DESC
				";
			}

		} else {
			
			if ($res->order_markers_by == '6'){
				global $wpgmza_tblname_categories;
				$wpgmza_sql1 = "SELECT $wpgmza_tblname.* FROM $wpgmza_tblname LEFT JOIN $wpgmza_tblname_categories ON $wpgmza_tblname.category = $wpgmza_tblname_categories.id WHERE $wpgmza_tblname.map_id = '$map_id' AND $wpgmza_tblname.approved = 1 ORDER BY $wpgmza_tblname_categories.priority $order_choice";
			} elseif ($order_by && $order_choice) {
				$wpgmza_sql1 = "
				SELECT *
				FROM $wpgmza_tblname
				WHERE `map_id` = '$map_id' AND `approved` = 1 ORDER BY `$order_by` $order_choice
				";
				
			} else {
			$wpgmza_sql1 = "
				SELECT *
				FROM $wpgmza_tblname
				WHERE `map_id` = '$map_id' AND `approved` = 1 ORDER BY `id` DESC
				";
			}
		}
	   

//		$marker_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpgmza_tblname WHERE map_id = %d",$map_id ) );
//		removed in 5.49 as it was showing up in the front end.
//		=========================================================
//		if ($marker_count > 5000) {
//			return __("There are too many markers to make use of the live edit function. The maximum amount for this functionality is 2000 markers. Anything more than that could crash your browser. In order to edit your markers, you would need to download the table in CSV format, edit it and re-upload it.","wp-google-maps");
//		} else {
//			
//		}
		$results = $wpdb->get_results($wpgmza_sql1);
		
		
		
		
		$wpgmza_tmp_body = "";
		$wpgmza_tmp_head = "";
		$wpgmza_tmp_footer = "";

	   

		$wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
		if (isset($wpgmza_settings['wpgmza_settings_image_resizing']) && $wpgmza_settings['wpgmza_settings_image_resizing'] == 'yes') { $wpgmza_image_resizing = true; } else { $wpgmza_image_resizing = false; }
		if (isset($wpgmza_settings['wpgmza_settings_image_height'])) { $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height']; } else { $wpgmza_image_height = false; }
		if (isset($wpgmza_settings['wpgmza_settings_image_width'])) { $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width']; } else { $wpgmza_image_width = false; }
		if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
		if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }
		if (isset($res->directions_enabled)) { $d_enabled = $res->directions_enabled; } else { $d_enabled = false; }
		
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_image']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_image'] == "yes") { $carousel_show_image = false; } else { $carousel_show_image = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_icon']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_icon'] == "yes") { $carousel_show_icon = false; } else { $carousel_show_icon = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_title']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_title'] == "yes") { $carousel_show_title = false; } else { $carousel_show_title = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_description']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_description'] == "yes") { $carousel_show_description = false; } else { $carousel_show_description = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_address']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_address'] == "yes") { $carousel_show_address = false; } else { $carousel_show_address = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_directions']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_directions'] == "yes") { $carousel_show_directions = false; } else { $carousel_show_directions = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_marker_link']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_marker_link'] == "yes") { $carousel_show_link = false; } else { $carousel_show_link = true; }
		if (isset($wpgmza_settings['wpgmza_settings_carousel_markerlist_resize_image']) && $wpgmza_settings['wpgmza_settings_carousel_markerlist_resize_image'] == "yes") { $carousel_resize_image = true; } else { $carousel_resize_image = false; }


		if (isset($wpgmza_settings['wpgmza_settings_markerlist_category'])) { $hide_category_column = $wpgmza_settings['wpgmza_settings_markerlist_category']; } else { $hide_category_column = false; } 
		if (isset($wpgmza_settings['wpgmza_settings_markerlist_icon'])) { $hide_icon_column = $wpgmza_settings['wpgmza_settings_markerlist_icon']; } else { $hide_icon_column = false; } 
		if (isset($wpgmza_settings['wpgmza_settings_markerlist_title'])) { $hide_title_column = $wpgmza_settings['wpgmza_settings_markerlist_title']; } else { $hide_title_column = false; } 
		if (isset($wpgmza_settings['wpgmza_settings_markerlist_address'])) { $hide_address_column = $wpgmza_settings['wpgmza_settings_markerlist_address']; } else { $hide_address_column = false; } 
		if (isset($wpgmza_settings['wpgmza_settings_markerlist_description'])) { $hide_description_column = $wpgmza_settings['wpgmza_settings_markerlist_description']; } else { $hide_description_column = false; } 

		/* count the categories that have been parsed into the function so we can total if this marker has been assigned to all of them. */
		if(is_array($category_data))
			$total_categories_parsed = count($category_data);
		else
			$total_categories_parsed = 0;

		$wmcnt = 0;

		foreach ( $results as $result ) {
			
			$marker_custom_fields = new CustomMarkerFields($result->id);
		   
			/* this handles the ajax data requests for the store locator */
			if (is_array($marker_array)) {
				$display = 0;
				foreach ($marker_array as $marker) {
					if ($marker == $result->id) { $display++; }
				}
			} else { $display = 1; /* show all markers as we havent passed through any marker variables to check */  }
			
			
			/* This handles the ajax data requests for the category filtering */
			
			
			/**
			 * Follow logic as set by user
			 *
			 * Do we display a marker that is either assigned to Cat A _OR_ Cat B?
			 * Or do we display the marker only if it is assigned to Cat A _AND_ Cat B?
			 *
			 * 0 = OR
			 * 1 = AND
			 */
			if (isset($wpgmza_settings['wpgmza_settings_cat_logic'])) { $cat_logic = intval( $wpgmza_settings['wpgmza_settings_cat_logic'] ); } else { $cat_logic = 0; }
			


			$c_display = 0;

			$marker_category = $result->category;
			$marker_category_data = explode(",",$marker_category);

			if ($cat_logic == 1) { 
			
				$total_marker_category_count = count($marker_category_data);
				if ($category_data == 'all' || !$category_data) { $c_display++; } else { // checkbox method
					if (is_array($category_data)) {
						foreach ($category_data as $cat) {
							foreach ($marker_category_data as $marker_cat) {
								if ($marker_cat == $cat) { $c_display++; }
							}
						}
					} else {
							$c_display = 0;
							foreach ($marker_category_data as $marker_cat) {
								if ($marker_cat == $category_data) { $c_display++; }
							}
					}

				}

				if ($c_display == $total_categories_parsed) {
					$c_display = 1;
				} else {
					$c_display = 0;
				}
				
				// Fixed AND category logic
				
				if(wp_doing_ajax() && !empty($marker_array))
					$c_display = 1;
				
			} 
			else {

				if ($category_data == 'all' || !$category_data) { $c_display++; } else { /* checkbox method */
					if (is_array($category_data)) {
						
						$c_display = 0;
						foreach ($category_data as $cat) {
							foreach ($marker_category_data as $marker_cat) {
								if ($marker_cat == $cat) { $c_display++; }
							}
						}
					} else { /* select method */
							$c_display = 0;
							foreach ($marker_category_data as $marker_cat) {
								if ($marker_cat == $category_data) { $c_display++; }
							}
					}
				}
				
			}





			// Temporary fix for marker listing blank, and for "marker listing blank" when using AND filtering
			if(is_array($marker_array) || $category_data == 'all')
				$c_display = 1;
			 
			if ($display > 0 && $c_display > 0) {
				
				
				$wmcnt++;
				if ($wmcnt%2) { $carousel_oddeven = "wpgmza_carousel_odd"; $oddeven = "wpgmaps_odd"; } else { $oddeven = "wpgmaps_even"; $carousel_oddeven = "wpgmza_carousel_even"; }

				$img = $result->pic;
				$link = $result->link;
				$icon = $result->icon;

				if (isset($result->approved)) {
					$approved = $result->approved;
					if ($approved == 0) {
						$show_approval_button = true;
					} else {
						$show_approval_button = false;
					}
				} else {
					$show_approval_button = false;
				}
				
				$category_icon = wpgmza_get_category_icon($result->category);
				
				// Marker icon image source
				$additional_img_class = "";
				if ($type == 4) 
					$additional_img_class = "wpgmza_small_img";
				
				$marker_icon_src = wpgmaps_get_plugin_url() . "/images/marker.png";
				$default_marker = "<img
					class='wpgmza_marker_icon $additional_img_class'
					src='$marker_icon_src'
					/>";

				if($category_icon)
					$marker_icon_src = $category_icon;

				if($icon)
					$marker_icon_src = $result->icon;

				$icon = "<img 
							class='wpgmza_marker_icon $additional_img_class' 
							src='$marker_icon_src'
							/>";

				// Link
				$linktd = "";
				if ($link)
					$linktd = "<a href='{$result->link}'
								class='wpgmza_marker_link' 
								target='_BLANK' 
								title='".__("View this link","wp-google-maps")."'>
								&gt;&gt;
								</a>";
				
				if ($admin) {
					$wpgmza_tmp_body .= "
						<tr id='wpgmza_tr_{$result->id}' class='gradeU'>
							<td height='40'>
								{$result->id}
							</td>
							<td height='40'>
								$icon
								<input type='hidden' 
									id='wpgmza_hid_marker_icon_{$result->id}' 
									value='{$result->icon}'
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_anim_{$result->id}' 
									value='{$result->anim}'
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_category_{$result->id}' 
									value='{$result->category}' 
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_infoopen_{$result->id}' 
									value='{$result->infoopen}' 
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_retina_{$result->id}' 
									value={$result->retina}' 
									/>
							</td>
							
							<td>
								".stripslashes($result->title)."
								<input type='hidden' 
									id='wpgmza_hid_marker_title_{$result->id}' 
									value='".stripslashes($result->title)."'
									/>
							</td>
							
							<td>
								".stripslashes(wpgmza_return_category_name($result->category))."
								<input type='hidden' 
									id='wpgmza_hid_marker_category_{$result->id}' 
									value='{$result->category}' 
									/>
							</td>
							
							<td>
								".stripslashes($result->address)."
								<input type='hidden' 
									id='wpgmza_hid_marker_address_{$result->id}' 
									value='".stripslashes($result->address)."' 
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_lat_{$result->id}' 
									value='{$result->lat}' 
									/>
								<input type='hidden' 
									id='wpgmza_hid_marker_lng_{$result->id}' 
									value='{$result->lng}'/>
							</td>
							
							<td>
								".stripslashes($result->description)."
								<input type='hidden' 
									id='wpgmza_hid_marker_desc_{$result->id}' 
									value='".  htmlspecialchars(stripslashes($result->description))."'
									/>
							</td>
							
							<td>
								$pic
								<input type='hidden' 
									id='wpgmza_hid_marker_pic_{$result->id}' 
									value='{$result->pic}'
									/>
							</td>
							
							<td>
								$linktd
								<input type='hidden' 
									id='wpgmza_hid_marker_link_{$result->id}' 
									value='{$result->link}'
									/>
							</td>
							
							<td width='170' align='center'>
							
								<a title='".__("Edit this marker","wp-google-maps")."' 
									class='wpgmza_edit_btn button' 
									id='{$result->id}'>
									<i class='fa fa-edit'></i>
								</a>
								<a href='?page=wp-google-maps-menu&action=edit_marker&id={$result->id}' 
									title='".__("Edit this marker","wp-google-maps")."' 
									class='wpgmza_edit_btn button' 
									id='{$result->id}'>
									<i class='fa fa-map-marker'></i>
								</a>";
								
								if ($show_approval_button)
									$wpgmza_tmp_body .= "<a href='javascript:void(0);'
															title='".__("Approve this marker","wp-google-maps")."' 
															class='wpgmza_approve_btn button' 
															id='{$result->id}'>
																<i class='fa fa-check'></i>
														</a>";
								
								$wpgmza_tmp_body .= "<a href='javascript:void(0);' 
														title='".__("Delete this marker","wp-google-maps")."' 
														class='wpgmza_del_btn button' 
														id='{$result->id}'>
															<i class='fa fa-times'></i>
													</a>
							</td>
						</tr>";
						
				} else {
					if ($type == 1)
					{
						$img = $result->pic;
						$wpgmaps_id = $result->id;
						$link = $result->link;
						$icon = $result->icon;
						$wpgmaps_lat = $result->lat;
						$wpgmaps_lng = $result->lng;
						$wpgmaps_address = $result->address;
						
						if (!$img) 
						{
							$pic = "<img src='".plugin_dir_url( dirname( __FILE__ ) )."images/no-image.jpg' 	
								class='wpgmza_map_image' 
								style='height: {$wpgmza_image_height}px; width: {$wpgmza_image_width}px;'
								/>";
						}
						else
						{
							if ($wpgmza_image_resizing)
								$pic = "<img src='{$result->pic}' 
									class='wpgmza_map_image' 
									style={height: {$wpgmza_image_height}px; width: {$wpgmza_image_width}px
									/>";
							else
								$pic = "<img src='{$result->pic}' 
											class='wpgmza_map_image'
											/>";
						
						}
						
						if (!$icon)
							$icon = $default_marker;
						else
							$icon = "<img class='$additional_img_class' 
										src='{$result->icon}'
										/>";
						
						$wpgmaps_dir_text = "";							
						if ($d_enabled == "1")
							$wpgmaps_dir_text = "<br/>
								<a href='javascript:void(0);'
									id='$map_id'
									title='".__("Get directions to","wp-google-maps")." ".esc_attr($result->title)."'
									class='wpgmza_gd'
									wpgm_addr_field='" . esc_attr($wpgmaps_address) . "'
									gps='{$wpgmaps_lat},{$wpgmaps_lng}'>".
										__("Directions","wp-google-maps")
								."</a>";
						
						$wpgmaps_desc_text = "";
						if ($result->description)
							$wpgmaps_desc_text = "<br />{$result->description}";
						
						$oddeven = 'wpgmaps_' . ($wmcnt % 2 ? 'odd' : 'even');

						$wpgmza_tmp_body .= "<div id='wpgmza_marker_{$result->id}'
												mid='{$result->id}'
												mapid='{$map_id}'
												class='wpgmaps_mlist_row wpgmza_basic_row $oddeven'>
												
												<div class='wpgmza-basic-listing-content-holder'>
													<div class='wpgmza-basic-listing-image-holder'>$pic</div>
														<div class='wpgmza-content-address-holder'>";
												
						if(!empty($result->title))
							$wpgmza_tmp_body .= "<p class='wpgmza-content-address-holder-inner'>
													<strong>
														<a href='javascript:void(0);'
															id='wpgmaps_marker_$wpgmaps_id' 
															title='".stripslashes($result->title)."'>"
															.stripslashes($result->title).
														"</a>
													</strong>
												</p>";
							
						if (!(isset($hide_icon_column) && $hide_icon_column == "yes"))
							$wpgmza_tmp_body .= $icon;

						if (!(isset($hide_address_column) && $hide_address_column == "yes"))
							$wpgmza_tmp_body .= "<div class='wpgmza-address'>
													".stripslashes($result->address)."
												</div>";
						
						if (!(isset($hide_description_column) && $hide_description_column == "yes"))
							$wpgmza_tmp_body .= "<div class='wpgmza-desc'>
													<p>".stripslashes($result->description)."</p>
													<p>$wpgmaps_dir_text</p>
												</div>";

						$wpgmza_tmp_body .= $marker_custom_fields->html();

						$wpgmza_tmp_body .= "			</div>
													</div>
												</div>";

					}
					else if ($type == 2)
					{
						$wpgmza_tmp_body .= "<tr id='wpgmza_marker_{$result->id}'
												mid='{$result->id}'
												mapid='{$map_id}'
												class='wpgmaps_mlist_row'>";

						if (!(isset($hide_icon_column) && $hide_icon_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_marker' height='40'>"
													.str_replace("'","\"",$icon).
												"</td>";

						if (!(isset($hide_title_column) && $hide_title_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_title all'>"
													.stripslashes($result->title).
												"</td>";

						if (!(isset($hide_category_column) && $hide_category_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_category'>"
													.stripslashes(wpgmza_return_category_name($result->category)). 
												"</td>";

						if (!(isset($hide_address_column) && $hide_address_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_address'>"
													.stripslashes($result->address).
												"</td>";

						if (!(isset($hide_description_column) && $hide_description_column == "yes")) 				
							$wpgmza_tmp_body .= "<td class='wpgmza_table_description'>"
													.stripslashes($result->description).
												"</td>";
						
						$custom_fields = new CustomFields();
						
						foreach($custom_fields as $field)
						{
							$name = $field->name;
							
							$value = (isset($marker_custom_fields->{$name}) ? $marker_custom_fields->{$name} : '');
							
							$wpgmza_tmp_body .= "<td class='wpgmza_table_" . htmlspecialchars($name) . "'>" . $value . "</td>";
						}
						
						$wpgmza_tmp_body .= "</tr>";
					}
					else if ($type == 3)
					{
						$pic = "";
						
						if($img)
						{
							$style = '';
							if ($wpgmza_image_resizing)
								$style = "style='height: {$wpgmza_image_height}px; width: {$wpgmza_image_width}px'";
							
							$pic = "<img src='{$result->pic}' 
										class='wpgmza_map_image' 
										$style
										/>";
						}

						$wpgmaps_dir_text = "";
						if ($d_enabled == "1")
							$wpgmaps_dir_text = 
								"<p class='wpgmza_marker_directions_link'>
									<a href='javascript:void(0);'
									id='{$map_id}'
									title='".__("Get directions to","wp-google-maps")." ".$result->title."' class='wpgmza_gd' 
									wpgm_addr_field='".stripslashes($result->address)."' 
									gps='".stripslashes($result->lat).",".stripslashes($result->lng)."'>"
										.__("Directions","wp-google-maps").
									"</a>
								</p>";

						$wpgmza_tmp_body .= 
							"<div class='owl-item item wpgmaps_mlist_row $carousel_oddeven'
								mid='{$result->id}' 
								mapid='{$map_id}'>";
								
						if ($carousel_show_image)
							$wpgmza_tmp_body .= "<div class='wpgmza_carousel_image_holder'>
													$pic
												</div>";
						
						if ($carousel_show_icon)
							$wpgmza_tmp_body .= "<div class='wpgmza_carousel_image_holder'>
													$icon
												</div>";

						$wpgmza_tmp_body .= "<div class='wpgmza_carousel_info_holder'>";
						
						if ($carousel_show_title)
							$wpgmza_tmp_body .= "<p class='wpgmza_marker_title'>"
													.stripslashes($result->title).
												"</p>";
						
						if ($carousel_show_address)
							$wpgmza_tmp_body .= "<p class='wpgmza_marker_address'>"
													.stripslashes($result->address).
												"</p>";
												
						if ($carousel_show_description)
							$wpgmza_tmp_body .= "<p class='wpgmza_marker_description'>"
													.stripslashes($result->description).
												"</p>";
					
						if ($carousel_show_link && !empty($result->link))
							$wpgmza_tmp_body .= "<p class='wpgmza_marker_link'>
													<a href='".stripslashes($result->link)."' target='_BLANK'>"
														.__( "Link", "wp-google-maps" ).
													"</a>
												</p>";
							
						if ($carousel_show_directions)
							$wpgmza_tmp_body .= $wpgmaps_dir_text;
						
						$wpgmza_tmp_body .= $marker_custom_fields->html();
						
						$wpgmza_tmp_body .= "   </div>";
						$wpgmza_tmp_body .= "</div>";

					} else if ($type == 4) {

						$wpgmza_tmp_body .= 
							"<div id='wpgmza_marker_{$result->id}' 
								mid='{$result->id}' 
								mapid='{$map_id}' 
								class='wpgmaps_blist_row'>";

						if (!(isset($hide_icon_column) && $hide_icon_column == "yes") )
							$wpgmza_tmp_body .= 
								"<div class='wpgmza-basic-list-item wpgmza_div_marker' 
									style='max-width: 14px; max-height: 14px;'>"
									.str_replace("'","\"",$icon).
								"</div>";

						$wpgmza_tmp_body .= "<div class='wpgmza-basic-list-item-wrapper'>";
						
						if (!(isset($hide_title_column) && $hide_title_column == "yes"))
							$wpgmza_tmp_body .= 
								"<div class='wpgmza-basic-list-item wpgmza_div_title'>"
									.stripslashes($result->title).
								"</div>";
						
						if (!(isset($hide_address_column) && $hide_address_column == "yes")) 
							$wpgmza_tmp_body .= 
								"<div class='wpgmza-basic-list-item wpgmza_div_address'> ("
									.stripslashes($result->address).
								")</div>";
						
						$wpgmza_tmp_body .= "</div>";

						$wpgmza_tmp_body .= $marker_custom_fields->html();
						
						$wpgmza_tmp_body .= "</div>"; 

					} else {
						$wpgmza_tmp_body .= 
							"<tr id='wpgmza_marker_{$result->id}' 
								mid='{$result->id}'
								mapid='$map_id'
								class='wpgmaps_mlist_row'>";
								
						if (!(isset($hide_icon_column) && $hide_icon_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_marker' height='40'>"
													.str_replace("'","\"",$icon).
												"</td>";
												
						if (!(isset($hide_title_column) && $hide_title_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_title all'>"
													.stripslashes($result->title).
												"</td>";
						
						if (!(isset($hide_category_column) && $hide_category_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_category'>"
													.stripslashes(wpgmza_return_category_name($result->category)).
												"</td>";

						if (!(isset($hide_address_column) && $hide_address_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_address'>"
													.stripslashes($result->address).
												"</td>";

						if (!(isset($hide_description_column) && $hide_description_column == "yes"))
							$wpgmza_tmp_body .= "<td class='wpgmza_table_description'>"
													.stripslashes($result->description).
												"</td>";

						$wpgmza_tmp_body .= "<td width='1px;' style='display:none; width:1px !important;'>
												<span style='display:none;'>"
													.sprintf('%02d', $result->id)."
												</span>
											</td>";
						
						$wpgmza_tmp_body .= $marker_custom_fields->html();
						
						$wpgmza_tmp_body .= "</tr>";				
					}
				}
			}
		}
		
		if ($admin) {
			$wpgmza_tmp_head .= 
				"<table id='wpgmza_table' 
					class='display' 
					cellspacing='0'
					cellpadding='0' 
					style='width:$width;'>
					<thead>
						<tr>
							<th>
								<strong>".__("ID","wp-google-maps")."</strong>
							</th>
							<th>
								<strong>".__("Icon","wp-google-maps")."</strong>
							</th>
							<th>
								<strong>".apply_filters("wpgmza_filter_title_name",__("Title","wp-google-maps"))."</strong>
							</th>
							<th>
								<strong>".apply_filters("wpgmza_filter_category_name",__("Category","wp-google-maps"))."</strong>
							</th>
							<th>
								<strong>".apply_filters("wpgmza_filter_address_name",__("Address","wp-google-maps"))."</strong>
							</th>
							<th>
								<strong>".apply_filters("wpgmza_filter_description_name",__("Description","wp-google-maps"))."</strong>
							</th>
							<th>
								<strong>".__("Image","wp-google-maps")."</strong>
							</th>
							<th>
								<strong>".__("Link","wp-google-maps")."</strong>
							</th>
							<th style='width:182px;'>
								<strong>".__("Action","wp-google-maps")."</strong>
							</th>
						</tr>
					</thead>
					<tbody>";
		} else {

			if ($type == 1) {
				$wpgmza_tmp_head .= 
					"<div id='wpgmza_marker_list_$map_id'
						class='wpgmza_marker_list_class' 
						style='width: $width;'>";
					
			} else if ($type == 2) {
				// Advanced marker listing
				if ($include_mlist_div)
					$wpgmza_tmp_head .= "<div id='wpgmza_marker_holder_$map_id' 
											class='wpgmza_marker_holder' 
											style='width: $width;'>";
				
				$wpgmza_tmp_head .= "<table id='wpgmza_table_$map_id' 
										class='wpgmza_table responsive' 
										cellspacing='0' 
										cellpadding='0' 
										style='width: $width;'>";

				$wpgmza_tmp_head .= "<thead>";
				$wpgmza_tmp_head .= "<tr>";

				if (!(isset($hide_icon_column) && $hide_icon_column == "yes"))
					$wpgmza_tmp_head .= "<th class='wpgmza_table_marker'>
											<strong></strong>
										</th>";
				
				if (!(isset($hide_title_column) && $hide_title_column == "yes"))
					$wpgmza_tmp_head .= "<th class='wpgmza_table_title all'>
											<strong>"
												.apply_filters("wpgmza_filter_title_name", __("Title","wp-google-maps")).
											"</strong>
										</th>";
				
				if (!(isset($hide_category_column) && $hide_category_column == "yes"))
					$wpgmza_tmp_head .= "<th class='wpgmza_table_category'>
											<strong>"
												.apply_filters("wpgmza_filter_category_name",__("Category","wp-google-maps")).
											"</strong>
										</th>";
				
				if (!(isset($hide_address_column) && $hide_address_column == "yes"))
					$wpgmza_tmp_head .= "<th class='wpgmza_table_address'>
											<strong>"
												.apply_filters("wpgmza_filter_address_name",__("Address","wp-google-maps")).
											"</strong>
										</th>";
				
				if (!(isset($hide_description_column) && $hide_description_column == "yes"))
					$wpgmza_tmp_head .= "<th class='wpgmza_table_description'>
											<strong>"
												.apply_filters("wpgmza_filter_description_name",__("Description","wp-google-maps")).
											"</strong>
										</th>";
				
				$custom_fields = new CustomFields();
				foreach($custom_fields as $field)
				{
					$name = $field->name;
					$wpgmza_tmp_head .= "<th class='wpgmza_table_" . htmlspecialchars($name) . "'>" . htmlspecialchars($name) . "</th>";
				}
				
				$wpgmza_tmp_head .= "</tr>
								</thead>
							<tbody>";

			} else if ($type == 3) {
				
				$wpgmza_tmp_head .= 
					"<div id='wpgmza_marker_list_container_$map_id' 
						class='wpgmza_marker_carousel'>
							<div id='wpgmza_marker_list_$map_id' 
								class='wpgmza_marker_carousel owl-carousel owl-theme'
								style='width: $width;'>";
					
			}  else if ($type == 4) {
				
				$wpgmza_tmp_head .= 
					"<div id='wpgmza_marker_list_$map_id' 
						class='wpgmza_marker_list_class wpgmza_basic_list' 
						style='width: $width'>";
				
			} else {
				/* advanced marker listing by default */
				$wpgmza_tmp_head .= 
					"<div id='wpgmza_marker_holder_$map_id' style='width: $width;'>
						<table id='wpgmza_table_$map_id' 
							class='wpgmza_table responsive' 
							cellspacing='0' 
							cellpadding='0' 
							style='width: $width;'>
							
							<thead>
								<tr>";
								
				if (!(isset($hide_icon_column) && $hide_icon_column == "yes"))
					$wpgmza_tmp_head .= 
						"<th class='wpgmza_table_marker'>
							<strong></strong>
						</th>";
				
				if (!(isset($hide_title_column) && $hide_title_column == "yes"))
					$wpgmza_tmp_head .= 
						"<th class='wpgmza_table_titleall'>
							<strong>"
								.apply_filters("wpgmza_filter_title_name",__("Title","wp-google-maps")).
							"</strong>
						</th>";
				
				if (!(isset($hide_category_column) && $hide_category_column == "yes"))
					$wpgmza_tmp_head .= 
						"<th class='wpgmza_table_category'>
							<strong>"
								.apply_filters("wpgmza_filter_category_name",__("Category","wp-google-maps")).
							"</strong>
						</th>";
				
				if (!(isset($hide_address_column) && $hide_address_column == "yes"))
					$wpgmza_tmp_head .= 
						"<th class='wpgmza_table_address'>
							<strong>"
								.apply_filters("wpgmza_filter_address_name",__("Address","wp-google-maps")).
							"</strong>
						</th>";
				
				if (!(isset($hide_description_column) && $hide_description_column == "yes"))
					$wpgmza_tmp_head .= 
						"<th class='wpgmza_table_description'>
							<strong>"
								.apply_filters("wpgmza_filter_description_name",__("Description","wp-google-maps")).
							"</strong>
						</th>";
				
				$wpgmza_tmp_head .= "<th width='1' style='display:none; width:1px !important;'></th>
								</tr>
							</thead>
						<tbody>";

			}
			
		}
		if ($admin) {
			$wpgmza_tmp_footer .= "</tbody>
								</table>";
		} else {
			if ($type == 1) {
				$wpgmza_tmp_footer .= "</div>";	   
					
			} else if ($type == 2) {
				$wpgmza_tmp_footer .= "</tbody>
									</table>";
									
				if ($include_mlist_div)
					$wpgmza_tmp_footer .= "</div><!-- end of marker list -->";
				
			} else if ($type == 3) {
				$wpgmza_tmp_footer .= "</div>
									</div>";

			} else if ($type == 4) {
				$wpgmza_tmp_footer .= "</div>";

			} else {
				$wpgmza_tmp_footer .= "</tbody>
									</table>
								</div>";
			}
		}

		return $wpgmza_tmp_head.$wpgmza_tmp_body.$wpgmza_tmp_footer;
			  
		
		
		
	}
	function get_map_data($map_id) {
		global $wpdb;
		global $wpgmza_tblname_maps;
		$result = $wpdb->get_results("
			SELECT *
			FROM $wpgmza_tblname_maps
			WHERE `id` = '".$map_id."' LIMIT 1
		");

		if (isset($result[0])) { return $result[0]; }
	}
	
	
	
}

