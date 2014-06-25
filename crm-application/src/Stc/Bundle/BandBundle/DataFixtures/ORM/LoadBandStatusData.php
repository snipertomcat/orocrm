<?php

namespace Stc\Bundle\BandBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Stc\Bundle\BandBundle\Entity\BandStatus;

/**
 * Loads task statuses.
 */
class LoadBandStatusData extends AbstractFixture
{
    /**
     * @var array
     */
    protected $data = array(
        0 => 'Disabled',
        1 => 'Enabled',
        2 => 'Deleted',
        3 => 'Suspended',
        4 => 'Banned'
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $statusName => $statusLabel) {
            if (!$this->isStatusExist($manager, $statusName)) {
                $entity = new BandStatus($statusName);
                $entity->setLabel($statusLabel);
                $manager->persist($entity);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $statusName
     * @return bool
     */
    protected function isStatusExist(ObjectManager $manager, $statusName)
    {
        return null !== $manager->getRepository('StcBandBundle:BandStatus')->find($statusName);
    }
}