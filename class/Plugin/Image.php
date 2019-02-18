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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         xcaptcha
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)

 */
class Image extends \XoopsModules\Xcaptcha\Captcha
{
    public $config = [];

    public $plugin;

    public function __construct()
    {
        $this->xcaptchaHandler = \XoopsModules\Xcaptcha\Captcha::getInstance();
        $this->config = $this->xcaptchaHandler->loadConfig('image');
        $this->plugin = 'image';
    }

    /**
     * @return array
     */
    public function VerifyData()
    {
        $system = \System::getInstance();
        $config = [];
        $_POST['num_chars'] = $system->cleanVars($_POST, 'num_chars', 6, 'int');
        $_POST['casesensitive'] = $system->cleanVars($_POST, 'casesensitive', false, 'boolean');
        $_POST['fontsize_min'] = $system->cleanVars($_POST, 'fontsize_min', 10, 'int');
        $_POST['fontsize_max'] = $system->cleanVars($_POST, 'fontsize_max', 24, 'int');
        $_POST['background_type'] = $system->cleanVars($_POST, 'background_type', 0, 'int');
        $_POST['background_num'] = $system->cleanVars($_POST, 'background_num', 50, 'int');
        $_POST['polygon_point'] = $system->cleanVars($_POST, 'polygon_point', 3, 'int');
        $_POST['skip_characters'] = $system->cleanVars($_POST, 'skip_characters', 'o|0|i|l|1', 'string');
        $_POST['skip_characters'] = explode('|', $_POST['skip_characters']);
        foreach (array_keys($this->config) as $key) {
            $config[$key] = $_POST[$key];
        }

        return $config;
    }
}
