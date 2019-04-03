VERSION 1.0.3:
- Update Home Lookbook

If you are new, please ignore this patch.
Please follow our steps to update:
- upload two folders app and pub to your magento root folder
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f