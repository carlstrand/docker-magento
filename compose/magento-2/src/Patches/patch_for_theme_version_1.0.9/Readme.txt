This patch is patch for theme version 1.0.9 fix group product display issue, if you are using old version and want to update to version 1.0.9 please follow our steps:
- Remove app\design\frontend\Mgs\mgsblank\Magento_Catalog
- Remove app\design\frontend\Mgs\orson\Magento_Catalog
- Upload app folder to your magento root folder.
- Refresh caches.
- Remove var/*
- Remove pub/static/frontend/Mgs
- Run deploy command: php bin/magento setup:static-content:deploy
If you are new, please ignore this patch.