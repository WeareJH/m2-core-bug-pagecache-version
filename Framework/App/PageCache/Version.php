<?php

namespace Jh\CoreBugPageCacheVersion\Framework\App\PageCache;

use Magento\Framework\App\PageCache\Version as PageCacheVersion;

/**
 * @author Michael Woodward <michael@wearejh.com>
 */
class Version extends PageCacheVersion
{
    /**
    * Override default to set cookie when not currently set
    * @see https://github.com/magento/magento2/pull/6406
    */
    public function process()
    {
        if ($this->request->isPost() || null === $this->cookieManager->getCookie(self::COOKIE_NAME)) {
            $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
                ->setDuration(self::COOKIE_PERIOD)
                ->setPath('/')
                ->setSecure($this->request->isSecure())
                ->setHttpOnly(false);
            $this->cookieManager->setPublicCookie(self::COOKIE_NAME, $this->generateValue(), $publicCookieMetadata);
        }
    }
}
