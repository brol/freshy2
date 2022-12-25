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

class freshy2Config
{
    public $ns;
    public $custom_theme;
    public $top_image;
    public $left_sidebar;
    public $right_sidebar;
    public $menu;

    protected function getSetting($name, $default)
    {
        $val = $this->ns->$name;
        if (!is_null($val)) {
            return $val;
        }
        $this->ns->put($name, $default, 'string');

        return $default;
    }

    public function store()
    {
        $this->ns->put('freshy2_custom', $this->custom_theme, 'string');
        $this->ns->put('freshy2_top_image', $this->top_image, 'string');
        $this->ns->put('freshy2_sidebar_left', $this->left_sidebar, 'string');
        $this->ns->put('freshy2_sidebar_right', $this->right_sidebar, 'string');
        $this->ns->put('freshy2_menu', $this->menu, 'string');
    }

    public function __construct()
    {
        dcCore::app()->blog->settings->addNamespace('freshy2');
        $this->ns            = dcCore::app()->blog->settings->freshy2;
        $this->custom_theme  = $this->getSetting('freshy2_custom', 'default');
        $this->top_image     = $this->getSetting('freshy2_top_image', 'default');
        $this->left_sidebar  = $this->getSetting('freshy2_sidebar_left', 'none');
        $this->right_sidebar = $this->getSetting('freshy2_sidebar_right', 'nav');
        $this->menu          = $this->getSetting('freshy2_menu', 'simplemenu');
    }

    public function getCustomThemes()
    {
        $themedir          = __DIR__ . '/..';
        $themes            = [];
        $themes['default'] = null;
        if ($dh = opendir($themedir)) {
            while (($file = readdir($dh)) !== false) {
                if (preg_match('/^custom_.*\.css$/i', (string) $file)) {
                    $custom          = preg_replace('/^custom_(.*)\.css$/i', '\\1', $file);
                    $themes[$custom] = $file;
                }
            }
        }

        return $themes;
    }

    public function getHeaderImages()
    {
        $headerdir = __DIR__ . '/../images/headers';
        $images    = [];
        $prefix    = dcCore::app()->adminurl->get('admin.blog.theme', ['shot' => 'freshy2', 'src' => 'images/headers/']);
        if ($dh = opendir($headerdir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file, 0, 1) != '.' && preg_match('/^.*\.(jpg|png|gif)$/i', $file)) {
                    $images[$file]        = [];
                    $images[$file]['img'] = $prefix . $file;
                    $thumb                = preg_replace('/^(.*).(jpg|gif|png)$/', '.$1_s.$2', (string) $file);
                    if (file_exists($headerdir . '/' . $thumb)) {
                        $images[$file]['thumb'] = $prefix . $thumb;
                    } else {
                        $images[$file]['thumb'] = $prefix . $file;
                    }
                }
            }
        }

        return $images;
    }
}
