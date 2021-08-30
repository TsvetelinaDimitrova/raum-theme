<?php

/**
 * Theme_support
 */
function raumplanung_theme_support(){
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('widgets');
    // add_theme_support( "custom-header", $args );
    // add_theme_support( "custom-background", $args );
}
add_action('after_setup_theme','raumplanung_theme_support');

/**
 * Register_styles
 */
function raumplanung_register_styles(){
  wp_enqueue_style('raumplanung-style', get_template_directory_uri(). "/style.css", array(), '0.1', 'all');
  wp_enqueue_style('raumplanung-forms-style', get_template_directory_uri(). "/css/forms.css", array(), null, 'all');
  /*wp_enqueue_style('raumplanung-calendar-custom-style', get_template_directory_uri(). "/calendar/style.css", array(), '1.0', 'all');*/
  wp_enqueue_style('raumplanung-event-calendar-custom-style', get_template_directory_uri(). "/event_calendar/style.css", array(), '1.0', 'all');
  wp_enqueue_style('raumplanung-event-calendar-full-style', get_template_directory_uri(). "/event_calendar/fullcalendar.min.css", array(), '3.4.0', 'all');

}
add_action('wp_enqueue_scripts', 'raumplanung_register_styles');

/**
 * Register_scripts
 */
function raumplanung_register_scripts(){
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), null, true);
  /* wp_enqueue_script('raumplanung-momentjs', get_template_directory_uri(). "/calendar/moment.min.js", array(), '2.5.1', true);*/
  /* wp_enqueue_script('raumplanung-calendar-custom-script', get_template_directory_uri(). "/calendar/script.js", array(), '1.0', true);*/
  wp_enqueue_script('raumplanung-event-calendar-jquery-wrapper-script', get_template_directory_uri(). "/event_calendar/jquery-wrapper.js", array('jquery'), '1.0', true);
  wp_enqueue_script('raumplanung-event-calendar-bootstrap-script', get_template_directory_uri(). "/event_calendar/bootstrap.min.js", array('jquery'), '3.3.7', true);
  wp_enqueue_script('raumplanung-event-calendar-moment-script', get_template_directory_uri(). "/event_calendar/moment.min.js", array('jquery'), '2.18.0', true);
  wp_enqueue_script('raumplanung-event-calendar-full-script', get_template_directory_uri(). "/event_calendar/fullcalendar.min.js", array('jquery'), '3.2.0', true);
  wp_enqueue_script('raumplanung-event-calendar-popper-script', get_template_directory_uri(). "/event_calendar/popper.min.js", array('jquery'), null, true);
  wp_enqueue_script('raumplanung-event-calendar-script', get_template_directory_uri(). "/event_calendar/script.js", array('jquery'), '1.0', true);

}
add_action('wp_enqueue_scripts', 'raumplanung_register_scripts');

/**
 * Registrierung_Formular
 * @var global $raumplanung_load_css;
 * @var output
 * @return [$output]                        [Ausgabe Eingabefelder]
 */
function raumplanung_registration_form() {

	// zeigt das Anmeldeformular nur für nicht eingeloggte Benutzern
	if(!is_user_logged_in()) {
    global $raumplanung_load_css;

		// setzt dies auf true, damit das CSS geladen wird
		$raumplanung_load_css = true;

		// überprüfen, ob die Benutzerregistrierung aktiviert ist
		$registration_enabled = get_option('users_can_register');

		// wenn aktiviert
		if($registration_enabled) {
			$output = raumplanung_registration_fields();
		} else {
			$output = __('User registration is not enabled');
		}
		return $output;
	}
}
add_shortcode('register_form', 'raumplanung_registration_form');

/**
 * Felder des Anmeldeformular
 * @return [function]
 */
function raumplanung_registration_fields() {

	ob_start(); ?>

		<?php
		// alle Fehlermeldungen nach dem Absenden des Formulars anzeigen
		raumplanung_register_messages(); ?>

		<form id="raumplanung_registration_form" class="raumplanung_form" action="" method="POST">
			<fieldset>
				<p>
					<label for="raumplanung_user_Login"><?php _e('Benutzername'); ?></label>
					<input name="raumplanung_user_login" id="raumplanung_user_login" class="raumplanung_user_login" type="text"/>
				</p>
				<p>
					<label for="raumplanung_user_email"><?php _e('E-mail'); ?></label>
					<input name="raumplanung_user_email" id="raumplanung_user_email" class="raumplanung_user_email" type="email"/>
				</p>
				<p>
					<label for="raumplanung_user_first"><?php _e('Vorname'); ?></label>
					<input name="raumplanung_user_first" id="raumplanung_user_first" type="text" class="raumplanung_user_first" />
				</p>
				<p>
					<label for="raumplanung_user_last"><?php _e('Nachname'); ?></label>
					<input name="raumplanung_user_last" id="raumplanung_user_last" type="text" class="raumplanung_user_last"/>
				</p>
				<p>
					<label for="password"><?php _e('Passwort'); ?></label>
					<input name="raumplanung_user_pass" id="password" class="password" type="password"/>
				</p>
				<p>
					<label for="password_again"><?php _e('Password wiederhollen'); ?></label>
					<input name="raumplanung_user_pass_confirm" id="password_again" class="password_again" type="password"/>
				</p>
				<p>
					<input type="hidden" name="raumplanung_csrf" value="<?php echo wp_create_nonce('raumplanung-csrf'); ?>"/>
					<input id="register-form" type="submit" value="<?php _e('Registrieren Sie Ihr Konto'); ?>"/>
				</p>
			</fieldset>
		</form>
	<?php
	return ob_get_clean();
}

/**
 * Einen neuen Benutzer registrieren
 */
function raumplanung_add_new_user() {
    if (isset( $_POST["raumplanung_user_login"] ) && wp_verify_nonce($_POST['raumplanung_csrf'], 'raumplanung-csrf')) {
      $user_login		= $_POST["raumplanung_user_login"];
      $user_email		= $_POST["raumplanung_user_email"];
      $user_first 	= $_POST["raumplanung_user_first"];
      $user_last	 	= $_POST["raumplanung_user_last"];
      $user_pass		= $_POST["raumplanung_user_pass"];
      $pass_confirm = $_POST["raumplanung_user_pass_confirm"];

      // dies ist für die Überprüfung des Benutzernamens erforderlich
      // require_once(ABSPATH . WPINC . '/registration.php');
      // veraltet

      if(username_exists($user_login)) {
          // Username already registered
          raumplanung_errors()->add('username_unavailable', __('Benutzername bereits vergeben'));
      }
      if(!validate_username($user_login)) {
          // ungültiger Benutzername
          raumplanung_errors()->add('username_invalid', __('Ungültiger Benutzername'));
      }
      if($user_login == '') {
          // leerer Benutzername
          raumplanung_errors()->add('username_empty', __('Bitte geben Sie einen Benutzernamen ein'));
      }
      if(!is_email($user_email)) {
          // ungültige Email
          raumplanung_errors()->add('email_invalid', __('Ungültige Email'));
      }
      if(email_exists($user_email)) {
          // E-Mail Adresse bereits registriert
          raumplanung_errors()->add('email_used', __('E-Mail Adresse bereits registriert'));
      }
      if($user_pass == '') {
          // Passwörter stimmen nicht überein
          raumplanung_errors()->add('password_empty', __('Bitte geben Sie ein Passwort ein'));
      }
      if($user_pass != $pass_confirm) {
          // Passwörter stimmen nicht überein
          raumplanung_errors()->add('password_mismatch', __('Passwörter stimmen nicht überein'));
      }

      $errors = raumplanung_errors()->get_error_messages();

      // wenn keine Fehler auftreten, dann Benutzer erstellen
      if(empty($errors)) {

          $new_user_id = wp_insert_user(array(
                  'user_login'		=> $user_login,
                  'user_pass'	 		=> $user_pass,
                  'user_email'		=> $user_email,
                  'first_name'		=> $user_first,
                  'last_name'			=> $user_last,
                  'user_registered'	=> date('Y-m-d H:i:s'),
                  'role'				=> 'subscriber'
              )
          );
          if($new_user_id) {
              // E-Mail an den Administrator senden
              wp_new_user_notification($new_user_id);

              // loggt den neuen Benutzer ein
              wp_setcookie($user_login, $user_pass, true);
              wp_set_current_user($new_user_id, $user_login);
              do_action('wp_login', $user_login);

              // den neu erstellten Benutzer nach dem Einloggen auf die Startseite schicken
              wp_redirect(home_url()); exit;
          }

      }

  }
}
add_action('init', 'raumplanung_add_new_user');

/**
 * Anmeldeformular für Benutzer
 * @var global
 * @return [function]                 [raumplanung_login_form_fields()]
 */
function raumplanung_login_form() {

	if(!is_user_logged_in()) {

		global $raumplanung_load_css;

		// setzt dies auf true, damit das CSS geladen wird
		$raumplanung_load_css = true;

		$output = raumplanung_login_form_fields();
	} else {
		// konnte einige angemeldete Benutzerinformationen hier anzeigen
		$output = '';
	}
	return $output;
}
add_shortcode('login_form', 'raumplanung_login_form');

/**
 * Login-Formularfelder
 * @return [function]
 */
function raumplanung_login_form_fields() {

	ob_start(); ?>

		<?php
		// alle Fehlermeldungen nach dem Absenden des Formulars anzeigen
		raumplanung_show_error_messages(); ?>

		<form id="raumplanung_login_form"  class="raumplanung_form"action="" method="post">
			<fieldset>
				<p>
					<label for="raumplanung_user_Login">Benutzername</label>
					<input name="raumplanung_user_login" id="raumplanung_user_login" class="required" type="text"/>
				</p>
				<p>
					<label for="raumplanung_user_pass">Passwort</label>
					<input name="raumplanung_user_pass" id="raumplanung_user_pass" class="required" type="password"/>
				</p>
				<p>
					<input type="hidden" name="raumplanung_login_nonce" value="<?php echo wp_create_nonce('raumplanung-login-nonce'); ?>"/>
					<input id="raumplanung_login_submit" type="submit" value="Login"/>
				</p>
			</fieldset>
		</form>
	<?php
	return ob_get_clean();
}

/**
 * loggt sich ein Mitglied nach dem Absenden eines Formulars ein
 * @var user
 * @var errors
 */
function raumplanung_login_member() {

	if(isset($_POST['raumplanung_user_login']) && wp_verify_nonce($_POST['raumplanung_login_nonce'], 'raumplanung-login-nonce')) {

		// dies gibt die Benutzer-ID und weitere Informationen aus dem Benutzernamen zurück
		$user = get_userdatabylogin($_POST['raumplanung_user_login']);

		if(!$user) {
			// wenn der Benutzername nicht existiert
			raumplanung_errors()->add('empty_username', __('Ungültiger Benutzername'));
		}

		if(!isset($_POST['raumplanung_user_pass']) || $_POST['raumplanung_user_pass'] == '') {
			// wenn kein Passwort eingegeben wurde
			raumplanung_errors()->add('empty_password', __('Bitte geben Sie ein Passwort ein'));
		}

		// den Login des Benutzers mit seinem Passwort überprüfen
		if(!wp_check_password($_POST['raumplanung_user_pass'], $user->user_pass, $user->ID)) {
			// wenn das Passwort für den angegebenen Benutzer nicht korrekt ist
			raumplanung_errors()->add('empty_password', __('Falsches Passwort'));
		}

		// alle Fehlermeldungen abrufen
		$errors = raumplanung_errors()->get_error_messages();

		// loggt den Benutzer nur ein, wenn es keine Fehler gibt
		if(empty($errors)) {

			wp_setcookie($_POST['raumplanung_user_login'], $_POST['raumplanung_user_pass'], true);
			wp_set_current_user($user->ID, $_POST['raumplanung_user_login']);
			do_action('wp_login', $_POST['raumplanung_user_login']);

			wp_redirect(home_url()); exit;
		}
	}
}
add_action('init', 'raumplanung_login_member');

/**
 * Verwendet für die Verfolgung von Fehlermeldungen
 * @var static wp_error
 * @return [new WP_Error]
 */
function raumplanung_errors(){
    static $wp_error; // global variable handle
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

/**
 * Zeigt Fehlermeldungen von Formularübermittlungen
 * @var code
 * @var message
 * @return [div]
 */
function raumplanung_show_error_messages() {
	if($codes = raumplanung_errors()->get_error_codes()) {
		echo '<div class="raumplanung_errors">';
		    // Schleifen-Fehlercodes und Anzeigefehler
		   foreach($codes as $code){
		        $message = raumplanung_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Fehler') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}
}

/**
 * Zeigt Fehlermeldungen von Formularübermittlungen
 * @var code
 * @var message
 * @return [div]
 */
function raumplanung_register_messages() {
	if($codes = raumplanung_errors()->get_error_codes()) {
		echo '<div class="raumplanung_errors">';
		    // Schleifen-Fehlercodes und Anzeigefehler
		   foreach($codes as $code){
		        $message = raumplanung_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}
}

/**
 * Registriert unser Formular css
 */
function raumplanung_register_css() {
	wp_register_style('raumplanung-form-css', get_template_directory_uri() . '/css/forms.css');
}
add_action('init', 'raumplanung_register_css');

/**
 * Ladet unser Formular css
 */
function raumplanung_print_css() {
	global $raumplanung_load_css;

	// diese Variable wird auf TRUE gesetzt, wenn der Shortcode auf einer Seite/einem Post verwendet wird
	if ( ! $raumplanung_load_css )
		return; // das bedeutet, dass kein Shortcode vorhanden ist, also verschwinden wir von hier.

	wp_print_styles('raumplanung-form-css');
}
add_action('wp_footer', 'raumplanung_print_css');

/**
 * Register Sidebar
 * @var locations
 */
function raumplanung_main_menus(){
    $locations = array(
        'primary' => "Header Menu Items",
        'footer' => "Footer Menu Items"
    );

    register_nav_menus($locations);
}
add_action('init', 'raumplanung_main_menus');

function my_sidebar()
{
    register_sidebar(
        array(
            'name' => 'Primary Sidebar',
            'id' => 'primary-sidebar',
            'description' => 'The Primary Area',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );

    /* register_sidebar(
        array(
            'name' => 'Secondary Sidebar',
            'id' => 'secondary-sidebar',
            'description' => 'The Secondary Area',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );*/
}
add_action('widgets_init', 'my_sidebar');

/**
 * Registrieren Custom Post type
 * @var args
 */
function raum_init() {
	$args = array(
		'labels' => array(
			'name' => __('Räume'),
			'singular_name' => __('Raum'),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array("slug" => __("räume")),
		'supports' => array('thumbnail','editor','title','custom-fields', 'page-attributes'),
    'menu_icon' => 'dashicons-store',
	);
	register_post_type( 'raeume' , $args );
}
add_action('init', 'raum_init');

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

/**
 *  Post-Typen zur Abfrage hinzufügen
 * @param  [$query]
 */
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'raeume' ) );
    return $query;
}
