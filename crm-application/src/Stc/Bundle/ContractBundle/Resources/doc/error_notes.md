# Error Notes

## 501
If the log shows unknown service definitions, delete the bootstrap.php.cache file and regenerate it, then clear cache:

cd C:\xampp\htdocs\orocrm\crm-application\vendor\sensio\distribution-bundle\Sensio\Bundle\DistributionBundle\Resources\bin;
php build_bootstrap.php;
php app/console cache:clear --env=prod;