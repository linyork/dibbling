<?php
/**
 * 設定 phpmyadmin cookie 過期時間
 */
$sessionValidity = 3600 * 24 * 365;
$cfg['LoginCookieValidity'] = $sessionValidity;
ini_set('session.gc_maxlifetime', $sessionValidity);