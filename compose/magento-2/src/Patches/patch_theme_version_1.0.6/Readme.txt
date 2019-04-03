VERSION 1.0.6:
- Update for magento 2.3

If you are new, please ignore this patch.
Please follow our steps to update:
- upload folder named app to your magento root folder
- upload folder named app from Themes\Magento 2.1+\Patches\patch_for_magento_2.3+ to your magento root folder
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f