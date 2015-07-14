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
		'title' => $lng['admin']['customer_add'],
		'image' => 'icons/user_add.png',
		'sections' => array(
			'section_b' => array(
				'title' => 'Abodetails',
				'image' => 'icons/user_add.png',
				'fields' => array(
					'code' => array(
						'label' => 'Abo Code',
						'type' => 'text',
						'mandatory' => true,
                        'maxlength' => 10,
                        'value' => $abo_kurz
					),
					'description' => array(
						'label' => 'Bezeichnung',
						'type' => 'text',
						'mandatory' => true,
                        'value' => $abo_desc
					)
				)
			),
			'section_c' => array(
				'title' => 'Kosten',
				'image' => 'icons/user_add.png',
				'fields' => array(
					'costs' => array(
						'label' => 'Monatliche Kosten',
						'type' => 'text',
						'mandatory' => true,
                        'value' => $abo_costs_mth
					),
					'costy' => array(
						'label' => 'J&auml;hrliche Kosten',
						'type' => 'text',
                        'value' => $abo_costs_year
					),
                    'paypal' => array(
						'label' => 'PayPal Code',
						'type' => 'text',
                        'mandatory' => true,
                        'value' => $paypal
					)
				)
			)
		)
	)
);
