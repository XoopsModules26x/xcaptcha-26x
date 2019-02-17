<?php

namespace XoopsModules\Xcaptcha\Plugin;

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
class Recaptcha extends \XoopsModules\Xcaptcha\Captcha
{
    public $config = [];

    public $plugin;

    public function __construct()
    {
        $this->xcaptchaHandler = \XoopsModules\Xcaptcha\Captcha::getInstance();
        $this->config = $this->xcaptchaHandler->loadConfig('recaptcha');
        $this->plugin = 'recaptcha';
    }

    /**
     * @return array
     */
    public function VerifyData()
    {
        $xoops = \Xoops::getInstance();
        $default_lang = array_search(ucfirst($xoops->getConfig('language')), $this->getLanguages(), true);
        $default_lang = (!$default_lang) ? 'en' : $default_lang;

        $system = \System::getInstance();
        $config = [];
        $_POST['private_key'] = $system->cleanVars($_POST, 'private_key', 'Your private key', 'string');
        $_POST['public_key'] = $system->cleanVars($_POST, 'public_key', 'Your public key', 'string');
        $_POST['theme'] = $system->cleanVars($_POST, 'theme', 'red', 'string');
        $_POST['lang'] = $system->cleanVars($_POST, 'lang', $default_lang, 'string');
        foreach (array_keys($this->config) as $key) {
            $config[$key] = $_POST[$key];
        }

        return $config;
    }

    /**
     * @return array
     */
    public function getThemes()
    {
        return [
            'red' => 'RED (default theme)',
            'white' => 'WHITE',
            'blackglass' => 'BLACKGLASS',
            'clean' => 'CLEAN', ];
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return [
            'en' => 'English',
            'nl' => 'Dutch',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'es' => 'Spanish',
            'tr' => 'Turkish', ];
    }
}
