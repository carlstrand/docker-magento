VERSION 1.0.1:
- Fix filter issue
- Fix register issue
- Fix style issue

If you are new, please ignore this patch.
Please follow our steps to update:
- upload app folder to your magento root folder
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f