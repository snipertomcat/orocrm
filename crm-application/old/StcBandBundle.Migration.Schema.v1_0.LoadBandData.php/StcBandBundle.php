<?php

namespace Stc\Bundle\BandBundle\Migration\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class StcBandBundle implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::stcBandsTable($schema);
        //self::stcBandsForeignKeys($schema);
    }

    /**
     * Generate table oro_ext_bands
     *
     * @param Schema $schema
     */
    public static function stcBandsTable(Schema $schema)
    {
        /** Generate table oro_ext_bands **/
        if ($schema->hasTable('oro_ext_bands')) {
            $schema->dropTable('oro_ext_bands');
        }
        $table = $schema->createTable('oro_ext_bands');
        $table->addColumn('id', 'string', ['length' => 40, 'notnull' => true]);
        $table->addColumn('created_by_user_id', 'string', ['length' => 40]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('createdAt', 'datetime', []);
        $table->addColumn('updatedAt', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_by_user_id', 'string', ['length' => 40, 'notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('deleted', 'integer', ['notnull' => false]);
        $table->addColumn('assigned_to_user_id', 'string', ['length' => 40, 'notnull' => false]);
        $table->addColumn('profile_type', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('industry', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('annual_revenue', 'decimal', ['notnull' => false]);
        $table->addColumn('phone_fax', 'integer', ['notnull' => false]);
        $table->addColumn('business_address_street', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('business_address_city', 'string', ['length' => 255]);
        $table->addColumn('business_address_state', 'string', ['length' => 255]);
        $table->addColumn('business_address_postalcode', 'string', ['length' => 255]);
        $table->addColumn('business_address_country', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('rating', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('phone_office', 'integer', ['notnull' => false]);
        $table->addColumn('phone_alternate', 'integer', ['notnull' => false]);
        $table->addColumn('website', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('ownership', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('employees', 'integer', ['notnull' => false]);
        $table->addColumn('ticker_symbol', 'string', ['length' => 15, 'notnull' => false]);
        $table->addColumn('shipping_address_street', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('shipping_address_city', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('shipping_address_state', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('shipping_address_postalcode', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('shipping_address_country', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('twitter', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('facebook', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('youtube', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('vimeo', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('myspace', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('reverbnation', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('linkdin', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('googleplus', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('tributeto', 'string', ['length' => 100]);
        $table->addColumn('genre', 'string', ['length' => 35]);
        $table->addColumn('contact_id_c', 'string', ['length' => 40]);
        $table->addColumn('act_type', 'string', ['length' => 45]);
        $table->addColumn('cache_id', 'string', ['length' => 40, 'notnull' => false]);
        $table->addColumn('jjwg_maps_lat_c', 'string', ['length' => 25, 'notnull' => false]);
        $table->addColumn('jjwg_maps_lng_c', 'string', ['length' => 25, 'notnull' => false]);
        $table->addColumn('owner_id', 'string', ['length' => 25, 'notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['owner_id'], 'IDX_403263ED9EB185F9', []);
        $table->addIndex(['assigned_to_user_id'], 'IDX_403263ED11578D11', []);
        $table->addIndex(['created_by_user_id'], 'IDX_403263ED7D182D95', []);
        /** End of generate table oro_ext_bands **/
    }

     /**
     * Generate foreign keys for table oro_ext_bands
     *
     * @param Schema $schema
     */
    public static function stcBandsForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table oro_ext_bands **/
        $table = $schema->getTable('oro_ext_bands');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['owner_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
    }

}
