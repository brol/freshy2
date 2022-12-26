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
if (!defined('DC_RC_PATH')) {
    return;
}

dcCore::app()->tpl->addValue('Freshy2StyleSheet', ['tplFreshy2Theme','FreshyStyleSheet']);
dcCore::app()->tpl->addValue('Freshy2LayoutClass', ['tplFreshy2Theme','FreshyLayoutClass']);
dcCore::app()->tpl->addBlock('Freshy2IfHasSidebar', ['tplFreshy2Theme','FreshyIfHasSidebar']);
dcCore::app()->tpl->addBlock('Freshy2IfHasSidebarContent', ['tplFreshy2Theme','FreshyIfHasSidebarContent']);
dcCore::app()->tpl->addBlock('Freshy2MenuIf', ['tplFreshy2Theme','FreshyMenuIf']);
dcCore::app()->addBehavior('publicHeadContent', ['tplFreshy2Theme','publicHeadContent']);
l10n::set(__DIR__ . '/locales/' . dcCore::app()->lang . '/public');
require __DIR__ . '/lib/class.freshy2.config.php';
class tplFreshy2Theme
{
    public static $config;
    public static $syssettings;

    public static function initSettings()
    {
        self::$config      = new freshy2Config();
        self::$syssettings = dcCore::app()->blog->settings->system;
    }

    public static function FreshyStyleSheet($attr)
    {
        return 'style.css';
    }

    public static function FreshyMenuIf($attr, $content)
    {
        if (isset($attr['name']) && $attr['name'] == 'freshymenu') {
            $menu = 'freshymenu';
        } else {
            $menu = 'simplemenu';
        }

        return '<?php if (tplFreshy2Theme::$config->menu == "' . $menu . '"): ?>' . "\n" .
            $content . "\n" .
            '<?php endif; ?>' . "\n";
    }

    public static function FreshyLayoutClass($attr)
    {
        $p = '<?php ' . "\n";
        $p .= 'if (tplFreshy2Theme::$config->right_sidebar != "none")' . "\n";
        $p .= '  echo "sidebar_right ";' . "\n";
        $p .= 'if (tplFreshy2Theme::$config->left_sidebar != "none")' . "\n";
        $p .= '  echo "sidebar_left";' . "\n";
        $p .= '?>' . "\n";

        return $p;
    }

    public static function FreshyIfHasSidebar($attr, $content)
    {
        if (isset($attr['pos'])) {
            $pos = trim(strtolower($attr['pos']));
        } else {
            $pos = 'right';
        }
        if ($pos == 'both') {
            return '<?php if ((tplFreshy2Theme::$config->left_sidebar != "none") ' .
                '&& (tplFreshy2Theme::$config->right_sidebar != "none")): ?>' . "\n" .
                $content . "\n" .
                '<?php endif; ?>' . "\n";
        }
        $setting = $pos . '_sidebar';

        return '<?php if (tplFreshy2Theme::$config->' . $setting . ' != "none"): ?>' . "\n" .
            $content . "\n" .
            '<?php endif; ?>' . "\n";
    }
    public static function FreshyIfHasSidebarContent($attr, $content)
    {
        if (isset($attr['pos'])) {
            $pos = trim(strtolower($attr['pos']));
        } else {
            $pos = 'right';
        }
        $setting = $pos . '_sidebar';
        if (isset($attr['value'])) {
            $value = trim(strtolower($attr['value']));
        } else {
            $value = 'nav';
        }

        return '<?php if (tplFreshy2Theme::$config->' . $setting . ' == "' . $value . '"): ?>' . "\n" .
            $content . "\n" .
            '<?php endif; ?>' . "\n";
    }

    public static function publicHeadContent()
    {
        $cust      = self::$config->custom_theme;
        $topimg    = self::$config->top_image;
        $theme_url = self::$syssettings->themes_url . '/' . self::$syssettings->theme;

        $css_content = '';
        if (empty($cust) === false && $cust !== 'default') {
            $css_content .= '@import url(' .
            $theme_url . '/' . $cust . ");\n";
        }
        if ($topimg !== null && $topimg !== 'default') {
            $css_content .= "#header_image {\n" .
                'background-image:url(' . $theme_url . '/images/headers/' . $topimg . ");\n" .
                "}\n";
        }
        if ($css_content != '') {
            echo '<style type="text/css" media="screen">' . "\n" .
                $css_content .
                "</style>\n";
        }
    }
}

tplFreshy2Theme::initSettings();
