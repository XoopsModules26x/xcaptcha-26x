<?php
/**
 * Xcaptcha extension module
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         xcaptcha
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

use XoopsModules\Xcaptcha\Form;
use XoopsModules\Xcaptcha;

include __DIR__ . '/header.php';

$xoops = \Xoops::getInstance();
$xcaptchaHandler = new \XoopsModules\Xcaptcha\Captcha();

switch ($op) {
    case 'save':
        if (!$xoops->security()->check()) {
            $xoops->redirect('index.php', 5, implode(',', $xoops->security()->getErrors()));
        }
        if ('config' === $type) {
            $config = $xcaptchaHandler->VerifyData();
            $xcaptchaHandler->writeConfig('captcha.config', $config);
            $xoops->redirect('index.php?type=config', 5, _AM_XCAPTCHA_SAVED);
        } else {
            if ($xcaptchaHandler->loadPluginHandler($type)) {
                $config = $xcaptchaHandler->Pluginhandler->VerifyData();
                $xcaptchaHandler->writeConfig('captcha.config.' . $type, $config);
                $xoops->redirect('index.php?type=' . $type, 5, _AM_XCAPTCHA_SAVED);
            }
        }
        break;
    case 'default':
    default:
        $type = isset($type) ? $type : 'config';

        $xoops->header();
        $xoops->theme()->addStylesheet('modules/xcaptcha/css/moduladmin.css');

        $admin_page = new \Xoops\Module\Admin();
        if ('config' === $type) {
            $admin_page->displayNavigation('index.php?type=config');
            $admin_page->addInfoBox(_AM_XCAPTCHA_FORM);
            // $form = $xoops->getModuleForm($xcaptchaHandler, 'captcha', 'xcaptcha');

            // $form = $helper->getForm($xcaptchaHandler, 'xcaptcha');
            $form = new Form\CaptchaForm($xcaptchaHandler);
            $admin_page->addInfoBoxLine($form->render());
        } else {
            if ($plugin = $xcaptchaHandler->loadPluginHandler($type)) {
                $title = constant('_XCAPTCHA_FORM_' . mb_strtoupper($type));
//                $form  = $xoops->getModuleForm($plugin, $type, 'xcaptcha');
                $class = 'XoopsModules\Xcaptcha\Form\\' . $type . 'Form';
                         $form  = new $class($plugin);
                             $admin_page->addInfoBox($title);
                $admin_page->addInfoBoxLine($form->render());
            } else {
                $xoops->redirect('index.php', 5, _AM_XCAPTCHA_ERROR);
            }
        }
        $admin_page->displayIndex();

        break;
}
include __DIR__ . '/footer.php';
