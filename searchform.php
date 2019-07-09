<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php _ex( 'Search for:', 'label' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search for&nbsp;&hellip;', 'placeholder', 'sanse-glck' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Find', 'submit button', 'sanse-glck' ); ?>" />
</form>