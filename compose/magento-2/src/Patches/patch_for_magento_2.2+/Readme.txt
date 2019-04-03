- upload app folder to your magento root folder
- remove app/design/frontend/Mgs/claue/Magento_ConfigurableProduct
- remove app/design/frontend/Mgs/claue/Magento_Swatches/web/js
- run command: php bin/magento module:enable MGS_ClaueTheme
- run command: php bin/magento module:enable MGS_Landing
- run command: php bin/magento setup:upgrade
- remove var/*
- remove generated/code
- run deploy command: php bin/magento setup:static-content:deploy -f

