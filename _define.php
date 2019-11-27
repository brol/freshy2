<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of Freshy2, a theme for Dotclear.
# Original WP Theme from Julien de Luca
# (http://www.jide.fr/francais/)
#
# Copyright (c) 2008-2018
# Bruno Hondelatte dsls@morefnu.org
# Pierre Van Glabeke contact@brol.info
# 
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------
if (!defined('DC_RC_PATH')) { return; }

/* date 12-02-2018 */
$this->registerModule(
	/* Name */			"Freshy v2",
	/* Description*/		"Freshy v2 customizable theme",
	/* Author */			"Bruno Hondelatte, Pierre Van Glabeke, Julien de Luca (original WP theme)",
	/* Version */			'2.0',
	array(
		'type'	 =>	'theme',
		'tplset' => 'mustek',
		'dc_min' => '2.15'
	)
);