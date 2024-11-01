<?php 
/*
Plugin Name: WP Prayer Times
Plugin URI: http://samimaxhuni.info/wp-prayer-time/
Description: Widgets for muslims prayer time
Version:1.0.0
Author: Sami Maxhuni
Author URI: http://samimaxhuni.info
*/

class prayer extends WP_Widget{
		private $api_url = 'http://samimaxhuni.info/prayer/jsonprayertimeserver.php?a=';

		public function prayer(){
			$widget_options = array(
				'classname' => 'WP Prayer Time',
				'description' => 'World wide prayer times'
			 );
			parent::WP_Widget('WP_Prayer_Time','WP Prayer Time', $widget_options);
		}
		public function widget($arg, $instance){
			extract($arg, EXTR_SKIP);
			$address = ( $instance['address'] ) ? $instance['address'] : 'Mitrovice,Kosovo';
			//Fetch data
			$prayer = wp_remote_get($this->api_url.urlencode($address));
			echo $before_widget;
			?>
			<?php
			$prayer = json_decode($prayer['body'], true);
			$prayer_time 	= $prayer['prayer_time'];
			$today_fajr 	= $prayer_time['Fajr'];
			$today_sunrise 	= $prayer_time['Sunrise'];
			$today_dhuhr 	= $prayer_time['Dhuhr'];
			$today_asr 		= $prayer_time['Asr'];
			$today_maghrib 	= $prayer_time['Maghrib'];
			$today_isha 	= $prayer_time['Isha'];
			?>
			
			<div id="wp-prayer-time">
				<h3 class="widgettitle"><?php _e('Prayer Time in '); echo $prayer['info']['city'];?></h3>
				<table style="width:100%;">
					<tbody>
						<tr>
							<td><?php _e('Fajr'); ?></td>
							<td style="font-weight: bold;"><?php echo $today_fajr; ?></td>
						</tr>

						<tr>
							<td><?php _e('Sunrise'); ?></td>
							<td style="font-weight: bold;"><?php echo $today_sunrise; ?></td>
						</tr>
						<tr>
							<td><?php _e('Dhuhr') ?></td>
							<td style="font-weight: bold;"><?php echo $today_dhuhr; ?></td>
						</tr>
						<tr>
							<td><?php _e('Asr'); ?></td>
							<td style="font-weight: bold;"><?php echo $today_asr; ?></td>
						</tr>
						<tr>
							<td><?php _e('Maghrib'); ?></td>
							<td style="font-weight: bold;"><?php echo $today_maghrib; ?></td>
						</tr>
						<tr>
							<td><?php _e('Isha'); ?></td>
							<td style="font-weight: bold;"><?php echo $today_isha; ?></td>
						</tr>
					</tbody>
				</table>	
        	</div>
			<?php
			echo $after_widget;
		}
		function update($new_instance, $old_instance){
			return $new_instance;
		}
		function form($instance){
			$address = esc_attr( $instance['address'] );
			?>
        		<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e( 'Address:' ); ?>
            		<input type="text" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo $address; ?>" id="<?php echo $this->get_field_id('address'); ?>" class="widefat" />
        		</label>
			<?php
		}
		
}
function wp_times_prayer(){
	register_widget('prayer');
}
add_action('widgets_init','wp_times_prayer');
?>