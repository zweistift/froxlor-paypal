<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Formfields
 *
 */
return array(
	'abo_add' => array(
		'title' => 'Kundenabo',
		'image' => 'icons/user_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => 'Abo Zuordnung',
				'image' => 'icons/user_add.png',
				'fields' => array(
					'abo-wish' => array(
						'label' => 'Abo Code',
						'type' => 'select',
						'select_var' => $abo_options,
                        'default' => $abo
					),
					'paypal' => array(
						'label' => 'PayPal Client ID',
						'type' => 'text',
                        'value' => '',
					)
				)
			)
		)
	)
);

