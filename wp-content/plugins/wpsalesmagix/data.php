<?php //require_once('wpsmagix.php');
	$wpsp = new wpsmagix();
	?>
<div class="wrap">
    <br />
    <h2>WP Sales Magix Data</h2>
    
    <?php if($response != NULL) : ?>
    
        <div class="updated settings-error" id="setting-error-settings_updated"> 
            <p>
                <strong><?php echo $response; $response = NULL; ?></strong>
            </p>
        </div>
        
    <?php else: ?>
        <br />
    <?php endif;   ?>
    
    <table class="widefat fixed comments">
    <thead>
    	<tr>
    		<th width="5%">Reg ID</th>
            <th width="30%">Full Name</th>
    		<th width="30%">Email</th>
    		<th width="10%">Date</th>
            <th width="15%">Action</th>
    	</tr>
    </thead>
    
    <tbody>
    
    <?php if( $entries ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $entries as $entry ) {
                $class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
            ?>
 
            <tr<?php echo $class; ?>>
                <td><?php echo $entry -> id; ?></td>
                <td><?php echo $entry -> full_name; ?></td>
                <td><?php echo $entry -> email; ?></td>
                <td><?php echo $entry -> timestamp; ?></td>
                <td><a onclick="return positive();" href="<?php echo str_replace('&delete=' . $_GET['delete'], '', $_SERVER['REQUEST_URI']) ?>&delete=<?php echo $entry -> id; ?>">Delete</a></td>
            </tr>
 
            <?php
                $count++;
            }
            ?>
 
        <?php } else { ?>
        <tr>
            <td colspan="5">No posts yet</td>
        </tr>
    <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
    		<th>Reg ID</th>
            <th>Full Name</th>
    		<th>Email</th>
    		<th>Date</th>
            <th>Action</th>
    	</tr>
    </tfoot>
    
    </table>
    
    <script type="text/javascript">
        function positive()
        {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
    
    <?php    
    
    $page_links = paginate_links( array(
        'base' => add_query_arg( 'pagenum', '%#%' ),
        'format' => '',
        'prev_text' => __( '&laquo;', 'aag' ),
        'next_text' => __( '&raquo;', 'aag' ),
        'total' => $num_of_pages,
        'current' => $pagenum
    ) );
     
    if ( $page_links ) {
        echo '<div class="tablenav" style="float: right;"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
    }

    ?>
    
    <div style="float: left; margin-top: 20px;">
        <form method="GET" action="<?php echo  $_SERVER['REQUEST_URI'] ?>">
            <ul>
                <li>
                    <input type="hidden" name="page" value="wpshareme_data" />
                    <input maxlength="3" size="1" name="limit" value="<?php echo $limit; ?>" /> &nbsp; 
                    <input type='submit' value='<?php _e('Limit Search'); ?>' class='button-secondary' />
                </li>                 
            </ul>
        </form
    ></div>
    
    <br />
    <div style="clear: both; padding-top: 10px;">
    	<a href="<?php echo $wpsp->plugin_url.'export.php'; ?>">Export Data</a>
    </div>
</div>