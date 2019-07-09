<form id="webmention-form" action="<?php echo get_webmention_endpoint(); ?>" class="form-grid-wrapper" method="post">
	<label for="webmention-source">
		<p><?php echo get_webmention_form_text( get_the_ID() ); ?></p>
	</label>
	<div class="form-grid">
		<input id="webmention-source" type="url" name="source" placeholder="<?php _e( 'URL/Permalink of your article', 'webmention' ); ?>" />
		<input id="webmention-submit" type="submit" name="submit" value="<?php _e( 'Ping me!', 'webmention' ); ?>" />
	</div>
	<input id="webmention-format" type="hidden" name="format" value="html" />
	<input id="webmention-target" type="hidden" name="target" value="<?php the_permalink(); ?>" />
</form><!-- #webmention-form -->