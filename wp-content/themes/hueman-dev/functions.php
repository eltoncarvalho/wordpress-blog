<?php
//Do not remove this
load_template( get_template_directory() . '/functions/init-core.php' );

/**
* The best and safest way to extend the Humean WordPress theme with your own custom code is to create a child theme.
* You can add temporary code snippets and hacks to the current functions.php file, but unlike with a child theme, they will be lost on upgrade.
*
* If you don't know what a child theme is, you really want to spend 5 minutes learning how to use child themes in WordPress, you won't regret it :) !
* https://codex.wordpress.org/Child_Themes
*
*/

//função que deixa i sistema em modo de matutenção.
//function maintenace_mode() {
//	if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
//		die('<h1 align="center">Estamos em Manutenção</h1>');
//	}
//}
//add_action('get_header', 'maintenace_mode'); */
//Fim função que deixa i sistema em modo de matutenção.


//Função coloca imagem destaque no post compartilhado .
function insert_image_src_rel_in_head() {
	global $post;
if ( !is_singular()) //verificar se é um post
return;
if(!has_post_thumbnail( $post->ID )) { //verifica se existe imagem desta
$default_image="http://eltonblog.esy.es/wp-content/uploads/2017/05/banner-blog2-520x245.png"; //coloque a url da imagem padrao 
echo '';
}
else{
	$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
	echo '';
}
echo "
";
}
add_action( 'wp_head', 'insert_image_src_rel_in_head', 5 );
//Fim função coloca imagem destaque no post compartilhado .


//função adicionar widget de contato.
//add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
//function my_custom_dashboard_widgets() {
//global $wp_meta_boxes;
//wp_add_dashboard_widget('custom_widget', 'Provérbios', 'custom_dashboard_information');
//}
//function custom_dashboard_information() {
//echo '<h1>"Cada cachorro que chupe a sua caceta..."</h1><br>';
//echo 'Elton Carvalho<br>';
//}
//Fim função adicionar widget de contato.

//função desativa bem vindo.
remove_action('welcome_panel', 'wp_welcome_panel');
//Fim função desativa bem vindo.



//em 1, adicione o ID do usuário que deseja remover os itens do menu
$user_id = get_current_user_id();
if ($user_id !== 1) { 
	function remove_menus(){
 remove_menu_page( 'themes.php' ); //Appearance - aparência (recomendo!)
 remove_menu_page( 'plugins.php' ); //Plugins (recomendo!)
 remove_menu_page( 'tools.php' ); //Tools - ferramentas (recomendo!)
 remove_menu_page( 'upload.php' ); //Tools - ferramentas (recomendo!)
 remove_menu_page( 'edit.php?post_type=page' ); //Tools - ferramentas (recomendo!)
}

//remove item do submenu do woocommerce
function remover_items_woo() {
	$remove = array( 'wc-settings', 'wc-status', 'wc-addons');
	foreach ( $remove as $submenu_slug ) {
		if ( $user_id !== 1 ) {
			remove_submenu_page( 'woocommerce', $submenu_slug );
		}
	}
}
//fim remove item do submenu do woocommerce


add_action( 'admin_menu', 'remove_menus' );
add_action( 'admin_menu', 'remover_items_woo', 99, 0 );

} else {}
//Fim adicione o ID do usuário que deseja remover os itens do menu


// função de remover mensagem de atualização.
function remove_upgrade_nag() {
	echo '<style type="text/css">
	.update-nag {display: none}
</style>';
}
add_action('admin_head', 'remove_upgrade_nag');
// fim da função de remover mensagem de atualização.


//Link na tela de login para a página inicial 
function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
	return 'Made with ♥ by Elton Carvalho';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
//Fim Link na tela de login para a página inicial 

//Adiciona nova logo na tela de login para a página inicial 
function cutom_login_logo() {
	echo "<style type=\"text/css\">
	body.login div#login h1 a {
		background-image: url(".get_bloginfo('template_directory')."/img/favicon.png);
		-webkit-background-size: auto;
		background-size: auto;
		margin: 0 0 25px;
		width: 320px;
	}
</style>";
}
add_action( 'login_enqueue_scripts', 'cutom_login_logo' );
//Fim adiciona nova logo na tela de login para a página inicial 


// Customizar o Footer do WordPress
function remove_footer_admin () {
	echo 'Made with ♥ by <a href="http://eltoncarvalho.esy.es/">Elton Carvalho</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');
// Fim Customizar o Footer do WordPress


// Saudação customizada
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Olá', 'Olá,', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );
// Fim Saudação customizada

