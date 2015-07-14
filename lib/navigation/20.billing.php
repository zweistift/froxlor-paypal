<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Navigation
 *
 */

return array (
	'customer' => array (
		'paypal' => array (
			'label' => $lng['modules']['paypal']['navtitle'],
			'show_element' => ( Settings::Get('paypal.enabled') == true ),
			'elements' => array (
                array (
					'url' => 'customer_paypal.php?page=invoices',
					'label' => $lng['modules']['paypal']['invoices'],
				),
                array (
					'url' => 'customer_paypal.php?page=details',
					'label' => $lng['modules']['paypal']['details'],
				),
			),
		),
	),
	'admin' => array (
		'paypal' => array (
			'label' => $lng['modules']['paypal']['navtitle'],
			'show_element' => ( Settings::Get('paypal.enabled') == true ),
			'elements' => array (
				array (
					'url' => 'admin_paypal.php?page=overview',
					'label' => $lng['modules']['paypal']['overview'],
				),
				array (
					'url' => 'admin_paypal.php?page=invoices',
					'label' => $lng['modules']['paypal']['invoices'],
				),
				array (
					'url' => 'admin_paypal.php?page=notifications',
					'label' => $lng['modules']['paypal']['notifications'],
				),
                array (
					'url' => 'admin_paypal.php?page=abos',
					'label' => $lng['modules']['paypal']['subscriptions'],
				),
			),
		),
	),
);
?>

