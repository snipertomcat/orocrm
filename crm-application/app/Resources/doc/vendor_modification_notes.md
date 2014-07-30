# Vendor Modification Notes

## Database Mod's

oro_user : added an 'image' field (binary) not required.
    -> Fixed an error thrown whenever a login was attempted (image field does not exist)
oro_user_api: same error as the one above, same mod: created image field on oro_user_api
    -> Same error as above



## Code Changes
