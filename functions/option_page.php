<?php
// create custom plugin settings menu
add_action('admin_menu', 'pickup_article_setting_menu');

function pickup_article_setting_menu() {

	//create new top-level menu
	add_menu_page('ピックアップ記事設定', 'Pickup設定', 'administrator', __FILE__, 'pickup_article_setting_page' );

	//call register settings function
	add_action( 'admin_init', 'register_pickup_article_setting' );
}


function register_pickup_article_setting() {
	register_setting( 'pickup_article_setting-group', 'pickup_1' );
	register_setting( 'pickup_article_setting-group', 'pickup_2' );
	register_setting( 'pickup_article_setting-group', 'pickup_3' );
	register_setting( 'pickup_article_setting-group', 'pickup_4' );
}

function pickup_article_setting_page() {
?>
<div class="wrap">
<h1>ピックアップ記事設定</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'pickup_article_setting-group' ); ?>
    <?php do_settings_sections( 'pickup_article_setting-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">ピックアップ記事</th>
        <td><input type="text" name="pickup_1" value="<?php echo esc_attr( get_option('pickup_1') ); ?>" /></td>
        <td><input type="text" name="pickup_2" value="<?php echo esc_attr( get_option('pickup_2') ); ?>" /></td>
        <td><input type="text" name="pickup_3" value="<?php echo esc_attr( get_option('pickup_3') ); ?>" /></td>
        <td><input type="text" name="pickup_4" value="<?php echo esc_attr( get_option('pickup_4') ); ?>" /></td>
        </tr>

    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php }

add_action( 'customize_register', 'theme_customize_register' );
function theme_customize_register($wp_customize) {
    $wp_customize->add_section( 'test_section', array(
        'title'          =>'オリジナルの項目',
        'priority'       => 100,
    ));
    /* ここの項目の設定を追加していきます。 */
    $wp_customize->add_setting('test_options[text01]', array(
       'type'  => 'option',
    ));
    $wp_customize->add_control( 'test_textfield', array(
        'settings' => 'test_options[text01]',
        'label' =>'テストテキストフィールド',
        'section' => 'test_section',
        'type' => 'text',
    ));

}
